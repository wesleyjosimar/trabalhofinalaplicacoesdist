import {
  Injectable,
  NotFoundException,
  BadRequestException,
} from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, FindManyOptions, Like, Between } from 'typeorm';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Amostra, StatusAmostra, TipoAmostra } from '../shared/entities/amostra.entity';
import { Resultado, TipoResultado } from '../shared/entities/resultado.entity';
import { Atleta } from '../shared/entities/atleta.entity';
import { Competicao } from '../shared/entities/competicao.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';
import { Auditoria, TipoEvento } from '../shared/entities/auditoria.entity';
import { CreateTesteDto } from './dto/create-teste.dto';
import { CreateAmostraDto } from './dto/create-amostra.dto';
import { CreateResultadoDto } from './dto/create-resultado.dto';
import { UpdateAmostraStatusDto } from './dto/update-amostra-status.dto';
import { ListTestesDto } from './dto/list-testes.dto';
import { v4 as uuidv4 } from 'uuid';

@Injectable()
export class AntidopingService {
  constructor(
    @InjectRepository(TesteAntidoping)
    private testeRepository: Repository<TesteAntidoping>,
    @InjectRepository(Amostra)
    private amostraRepository: Repository<Amostra>,
    @InjectRepository(Resultado)
    private resultadoRepository: Repository<Resultado>,
    @InjectRepository(Atleta)
    private atletaRepository: Repository<Atleta>,
    @InjectRepository(Competicao)
    private competicaoRepository: Repository<Competicao>,
    @InjectRepository(Laboratorio)
    private laboratorioRepository: Repository<Laboratorio>,
    @InjectRepository(Auditoria)
    private auditoriaRepository: Repository<Auditoria>,
  ) {}

  async createTeste(
    createTesteDto: CreateTesteDto,
    usuarioId: string,
    usuarioEmail: string,
  ): Promise<TesteAntidoping> {
    const { atletaId, competicaoId, ...testeData } = createTesteDto;

    // Verificar se o atleta existe
    const atleta = await this.atletaRepository.findOne({
      where: { id: atletaId },
    });
    if (!atleta) {
      throw new NotFoundException(`Atleta com ID ${atletaId} não encontrado`);
    }

    // Verificar se a competição existe (se fornecida)
    let competicao: Competicao | null = null;
    if (competicaoId) {
      competicao = await this.competicaoRepository.findOne({
        where: { id: competicaoId },
      });
      if (!competicao) {
        throw new NotFoundException(`Competição com ID ${competicaoId} não encontrada`);
      }
    }

    const teste = this.testeRepository.create({
      ...testeData,
      atleta,
      competicao,
    });

    const savedTeste = await this.testeRepository.save(teste);

    // Registrar auditoria
    await this.registrarAuditoria(
      'TesteAntidoping',
      savedTeste.id,
      TipoEvento.CRIAÇÃO,
      usuarioId,
      usuarioEmail,
      null,
      savedTeste,
    );

    return savedTeste;
  }

  async findAllTestes(listTestesDto: ListTestesDto) {
    const {
      page = 1,
      limit = 10,
      atletaId,
      competicaoId,
      dataInicio,
      dataFim,
    } = listTestesDto;
    const skip = (page - 1) * limit;

    const options: FindManyOptions<TesteAntidoping> = {
      relations: ['atleta', 'atleta.federacao', 'atleta.clubeAtual', 'competicao', 'amostras'],
      skip,
      take: limit,
      order: { dataColeta: 'DESC' },
    };

    const where: any = {};
    if (atletaId) {
      where.atletaId = atletaId;
    }
    if (competicaoId) {
      where.competicaoId = competicaoId;
    }
    if (dataInicio && dataFim) {
      where.dataColeta = Between(new Date(dataInicio), new Date(dataFim));
    } else if (dataInicio) {
      where.dataColeta = Between(new Date(dataInicio), new Date());
    }

    if (Object.keys(where).length > 0) {
      options.where = where;
    }

    const [data, total] = await this.testeRepository.findAndCount(options);

    return {
      data,
      total,
      page,
      limit,
      totalPages: Math.ceil(total / limit),
    };
  }

  async findOneTeste(id: string): Promise<TesteAntidoping> {
    const teste = await this.testeRepository.findOne({
      where: { id },
      relations: [
        'atleta',
        'atleta.federacao',
        'atleta.clubeAtual',
        'competicao',
        'amostras',
        'amostras.resultado',
        'amostras.resultado.laboratorio',
      ],
    });

    if (!teste) {
      throw new NotFoundException(`Teste com ID ${id} não encontrado`);
    }

    return teste;
  }

  async createAmostra(
    testeId: string,
    createAmostraDto: CreateAmostraDto,
    usuarioId: string,
    usuarioEmail: string,
  ): Promise<Amostra> {
    const teste = await this.findOneTeste(testeId);

    // Verificar se já existe amostra do mesmo tipo
    const amostraExistente = await this.amostraRepository.findOne({
      where: {
        testeId,
        tipo: createAmostraDto.tipo,
      },
    });

    if (amostraExistente) {
      throw new BadRequestException(
        `Já existe uma amostra do tipo ${createAmostraDto.tipo} para este teste`,
      );
    }

    // Gerar código único se não fornecido
    const codigo = createAmostraDto.codigo || this.gerarCodigoAmostra(createAmostraDto.tipo);

    const amostra = this.amostraRepository.create({
      ...createAmostraDto,
      codigo,
      teste,
    });

    const savedAmostra = await this.amostraRepository.save(amostra);

    // Registrar auditoria
    await this.registrarAuditoria(
      'Amostra',
      savedAmostra.id,
      TipoEvento.CRIAÇÃO,
      usuarioId,
      usuarioEmail,
      null,
      savedAmostra,
    );

    return savedAmostra;
  }

  async createResultado(
    amostraId: string,
    createResultadoDto: CreateResultadoDto,
    usuarioId: string,
    usuarioEmail: string,
  ): Promise<Resultado> {
    const amostra = await this.amostraRepository.findOne({
      where: { id: amostraId },
      relations: ['resultado', 'teste'],
    });

    if (!amostra) {
      throw new NotFoundException(`Amostra com ID ${amostraId} não encontrada`);
    }

    // Verificar se já existe resultado
    if (amostra.resultado) {
      throw new BadRequestException('Esta amostra já possui um resultado registrado');
    }

    // Verificar se o laboratório existe
    const laboratorio = await this.laboratorioRepository.findOne({
      where: { id: createResultadoDto.laboratorioId },
    });
    if (!laboratorio) {
      throw new NotFoundException(
        `Laboratório com ID ${createResultadoDto.laboratorioId} não encontrado`,
      );
    }

    const resultado = this.resultadoRepository.create({
      ...createResultadoDto,
      amostra,
      laboratorio,
    });

    const savedResultado = await this.resultadoRepository.save(resultado);

    // Atualizar status da amostra
    amostra.status =
      createResultadoDto.resultado === TipoResultado.POSITIVO
        ? StatusAmostra.POSITIVA
        : createResultadoDto.resultado === TipoResultado.NEGATIVO
        ? StatusAmostra.NEGATIVA
        : StatusAmostra.INCONCLUSIVA;
    amostra.status = StatusAmostra.ANALISADA;
    await this.amostraRepository.save(amostra);

    // Registrar auditoria
    await this.registrarAuditoria(
      'Resultado',
      savedResultado.id,
      TipoEvento.REGISTRO_RESULTADO,
      usuarioId,
      usuarioEmail,
      null,
      savedResultado,
    );

    return savedResultado;
  }

  async getCadeiaCustodia(amostraId: string): Promise<any> {
    const amostra = await this.amostraRepository.findOne({
      where: { id: amostraId },
      relations: [
        'teste',
        'teste.atleta',
        'resultado',
        'resultado.laboratorio',
      ],
    });

    if (!amostra) {
      throw new NotFoundException(`Amostra com ID ${amostraId} não encontrada`);
    }

    // Buscar eventos de auditoria relacionados
    const eventos = await this.auditoriaRepository.find({
      where: [
        { entidade: 'Amostra', entidadeId: amostraId },
        { entidade: 'Resultado', entidadeId: amostra.resultado?.id || '' },
      ],
      order: { createdAt: 'ASC' },
    });

    return {
      amostra: {
        id: amostra.id,
        codigo: amostra.codigo,
        tipo: amostra.tipo,
        status: amostra.status,
        createdAt: amostra.createdAt,
      },
      teste: {
        id: amostra.teste.id,
        dataColeta: amostra.teste.dataColeta,
        localColeta: amostra.teste.localColeta,
        coletor: amostra.teste.coletor,
        atleta: {
          id: amostra.teste.atleta.id,
          nome: amostra.teste.atleta.nome,
          documento: amostra.teste.atleta.documento,
        },
      },
      resultado: amostra.resultado
        ? {
            id: amostra.resultado.id,
            resultado: amostra.resultado.resultado,
            dataAnalise: amostra.resultado.dataAnalise,
            laboratorio: {
              id: amostra.resultado.laboratorio.id,
              nome: amostra.resultado.laboratorio.nome,
              codigo: amostra.resultado.laboratorio.codigo,
            },
          }
        : null,
      eventos: eventos.map((evento) => ({
        tipo: evento.tipoEvento,
        usuario: evento.usuarioEmail,
        data: evento.createdAt,
        observacoes: evento.observacoes,
      })),
    };
  }

  async solicitarReanalise(
    testeId: string,
    usuarioId: string,
    usuarioEmail: string,
  ): Promise<Amostra> {
    const teste = await this.findOneTeste(testeId);

    // Buscar amostra B
    const amostraB = await this.amostraRepository.findOne({
      where: {
        testeId,
        tipo: TipoAmostra.B,
      },
    });

    if (!amostraB) {
      throw new NotFoundException('Amostra B não encontrada para este teste');
    }

    // Verificar se a amostra A tem resultado positivo
    const amostraA = await this.amostraRepository.findOne({
      where: {
        testeId,
        tipo: TipoAmostra.A,
      },
      relations: ['resultado'],
    });

    if (!amostraA || !amostraA.resultado) {
      throw new BadRequestException(
        'A amostra A precisa ter um resultado registrado antes de solicitar reanálise',
      );
    }

    if (amostraA.resultado.resultado !== TipoResultado.POSITIVO) {
      throw new BadRequestException('A reanálise só é permitida quando a amostra A é positiva');
    }

    // Registrar auditoria
    await this.registrarAuditoria(
      'Amostra',
      amostraB.id,
      TipoEvento.SOLICITAÇÃO_REANÁLISE,
      usuarioId,
      usuarioEmail,
      null,
      { testeId, amostraId: amostraB.id },
    );

    return amostraB;
  }

  async updateAmostraStatus(
    amostraId: string,
    updateStatusDto: UpdateAmostraStatusDto,
    usuarioId: string,
    usuarioEmail: string,
  ): Promise<Amostra> {
    const amostra = await this.amostraRepository.findOne({
      where: { id: amostraId },
      relations: ['resultado'],
    });

    if (!amostra) {
      throw new NotFoundException(`Amostra com ID ${amostraId} não encontrada`);
    }

    const statusAnterior = amostra.status;
    amostra.status = updateStatusDto.status;

    // Validações de negócio
    if (updateStatusDto.status === StatusAmostra.POSITIVA && !amostra.resultado) {
      throw new BadRequestException(
        'Não é possível marcar amostra como positiva sem um resultado registrado',
      );
    }

    if (updateStatusDto.status === StatusAmostra.NEGATIVA && !amostra.resultado) {
      throw new BadRequestException(
        'Não é possível marcar amostra como negativa sem um resultado registrado',
      );
    }

    const amostraAtualizada = await this.amostraRepository.save(amostra);

    // Registrar auditoria
    await this.registrarAuditoria(
      'Amostra',
      amostraId,
      TipoEvento.ATUALIZAÇÃO,
      usuarioId,
      usuarioEmail,
      { status: statusAnterior },
      { status: updateStatusDto.status },
    );

    return amostraAtualizada;
  }

  private gerarCodigoAmostra(tipo: TipoAmostra): string {
    const timestamp = Date.now();
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    return `AM${tipo}-${timestamp}-${random}`;
  }

  private async registrarAuditoria(
    entidade: string,
    entidadeId: string,
    tipoEvento: TipoEvento,
    usuarioId: string,
    usuarioEmail: string,
    dadosAntigos: any,
    dadosNovos: any,
  ): Promise<void> {
    const auditoria = this.auditoriaRepository.create({
      entidade,
      entidadeId,
      tipoEvento,
      usuarioId,
      usuarioEmail,
      dadosAntigos: dadosAntigos ? JSON.stringify(dadosAntigos) : null,
      dadosNovos: dadosNovos ? JSON.stringify(dadosNovos) : null,
    });

    await this.auditoriaRepository.save(auditoria);
  }
}


