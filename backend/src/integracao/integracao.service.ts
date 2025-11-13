import { Injectable, NotFoundException, BadRequestException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Resultado } from '../shared/entities/resultado.entity';
import { Amostra, StatusAmostra } from '../shared/entities/amostra.entity';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';
import { LaboratorioResultadoDto } from './dto/laboratorio-resultado.dto';
import { TipoResultado } from '../shared/entities/resultado.entity';

@Injectable()
export class IntegracaoService {
  constructor(
    @InjectRepository(Resultado)
    private resultadoRepository: Repository<Resultado>,
    @InjectRepository(Amostra)
    private amostraRepository: Repository<Amostra>,
    @InjectRepository(TesteAntidoping)
    private testeRepository: Repository<TesteAntidoping>,
    @InjectRepository(Laboratorio)
    private laboratorioRepository: Repository<Laboratorio>,
  ) {}

  async receberResultadoLaboratorio(
    laboratorioId: string,
    resultadoDto: LaboratorioResultadoDto,
  ): Promise<Resultado> {
    // Verificar se o laboratório existe
    const laboratorio = await this.laboratorioRepository.findOne({
      where: { id: laboratorioId },
    });

    if (!laboratorio) {
      throw new NotFoundException(`Laboratório com ID ${laboratorioId} não encontrado`);
    }

    // Buscar amostra pelo código
    const amostra = await this.amostraRepository.findOne({
      where: { codigo: resultadoDto.codigoAmostra },
      relations: ['resultado'],
    });

    if (!amostra) {
      throw new NotFoundException(
        `Amostra com código ${resultadoDto.codigoAmostra} não encontrada`,
      );
    }

    // Verificar se já existe resultado
    if (amostra.resultado) {
      throw new BadRequestException('Esta amostra já possui um resultado registrado');
    }

    // Criar resultado
    const resultado = this.resultadoRepository.create({
      amostra,
      laboratorio,
      resultado: resultadoDto.resultado as TipoResultado,
      dataAnalise: new Date(resultadoDto.dataAnalise),
      detalhes: resultadoDto.detalhes,
      substanciaEncontrada: resultadoDto.substanciaEncontrada,
      concentracao: resultadoDto.concentracao,
    });

    const savedResultado = await this.resultadoRepository.save(resultado);

    // Atualizar status da amostra
    if (resultadoDto.resultado === TipoResultado.POSITIVO) {
      amostra.status = StatusAmostra.POSITIVA;
    } else if (resultadoDto.resultado === TipoResultado.NEGATIVO) {
      amostra.status = StatusAmostra.NEGATIVA;
    } else {
      amostra.status = StatusAmostra.INCONCLUSIVA;
    }
    await this.amostraRepository.save(amostra);

    return savedResultado;
  }

  async consultarTestes(filtros: {
    atletaId?: string;
    competicaoId?: string;
    dataInicio?: string;
    dataFim?: string;
  }): Promise<TesteAntidoping[]> {
    // Endpoint para órgãos reguladores consultarem testes
    // Por enquanto, retorna dados limitados
    const query = this.testeRepository.createQueryBuilder('teste')
      .leftJoinAndSelect('teste.atleta', 'atleta')
      .leftJoinAndSelect('teste.competicao', 'competicao')
      .leftJoinAndSelect('teste.amostras', 'amostras')
      .leftJoinAndSelect('amostras.resultado', 'resultado');

    if (filtros.atletaId) {
      query.andWhere('teste.atletaId = :atletaId', { atletaId: filtros.atletaId });
    }

    if (filtros.competicaoId) {
      query.andWhere('teste.competicaoId = :competicaoId', { competicaoId: filtros.competicaoId });
    }

    if (filtros.dataInicio && filtros.dataFim) {
      query.andWhere('teste.dataColeta BETWEEN :dataInicio AND :dataFim', {
        dataInicio: filtros.dataInicio,
        dataFim: filtros.dataFim,
      });
    }

    return query.getMany();
  }
}

