import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, FindManyOptions, Like } from 'typeorm';
import { Atleta } from '../shared/entities/atleta.entity';
import { Clube } from '../shared/entities/clube.entity';
import { Federacao } from '../shared/entities/federacao.entity';
import { HistoricoClube } from '../shared/entities/historico-clube.entity';
import { CreateAtletaDto } from './dto/create-atleta.dto';
import { UpdateAtletaDto } from './dto/update-atleta.dto';
import { ListAtletasDto } from './dto/list-atletas.dto';

@Injectable()
export class AtletasService {
  constructor(
    @InjectRepository(Atleta)
    private atletaRepository: Repository<Atleta>,
    @InjectRepository(Clube)
    private clubeRepository: Repository<Clube>,
    @InjectRepository(Federacao)
    private federacaoRepository: Repository<Federacao>,
    @InjectRepository(HistoricoClube)
    private historicoClubeRepository: Repository<HistoricoClube>,
  ) {}

  async create(createAtletaDto: CreateAtletaDto): Promise<Atleta> {
    const { clubeAtualId, federacaoId, ...atletaData } = createAtletaDto;

    // Verificar se a federação existe
    const federacao = await this.federacaoRepository.findOne({
      where: { id: federacaoId },
    });
    if (!federacao) {
      throw new NotFoundException(`Federação com ID ${federacaoId} não encontrada`);
    }

    // Verificar se o clube existe (se fornecido)
    let clubeAtual: Clube | null = null;
    if (clubeAtualId) {
      clubeAtual = await this.clubeRepository.findOne({
        where: { id: clubeAtualId },
      });
      if (!clubeAtual) {
        throw new NotFoundException(`Clube com ID ${clubeAtualId} não encontrado`);
      }
    }

    const atleta = this.atletaRepository.create({
      ...atletaData,
      federacao,
      clubeAtual,
    });

    const savedAtleta = await this.atletaRepository.save(atleta);

    // Se houver clube atual, criar histórico
    if (clubeAtual) {
      const historico = this.historicoClubeRepository.create({
        atleta: savedAtleta,
        clube: clubeAtual,
        dataInicio: new Date(),
      });
      await this.historicoClubeRepository.save(historico);
    }

    return savedAtleta;
  }

  async findAll(listAtletasDto: ListAtletasDto) {
    const { page = 1, limit = 10, nome, documento, federacaoId, clubeId } = listAtletasDto;
    const skip = (page - 1) * limit;

    const options: FindManyOptions<Atleta> = {
      relations: ['federacao', 'clubeAtual'],
      skip,
      take: limit,
      order: { nome: 'ASC' },
    };

    const where: any = {};
    if (nome) {
      where.nome = Like(`%${nome}%`);
    }
    if (documento) {
      where.documento = Like(`%${documento}%`);
    }
    if (federacaoId) {
      where.federacaoId = federacaoId;
    }
    if (clubeId) {
      where.clubeAtualId = clubeId;
    }

    if (Object.keys(where).length > 0) {
      options.where = where;
    }

    const [data, total] = await this.atletaRepository.findAndCount(options);

    return {
      data,
      total,
      page,
      limit,
      totalPages: Math.ceil(total / limit),
    };
  }

  async findOne(id: string): Promise<Atleta> {
    const atleta = await this.atletaRepository.findOne({
      where: { id },
      relations: ['federacao', 'clubeAtual', 'historicoClubes', 'historicoClubes.clube'],
    });

    if (!atleta) {
      throw new NotFoundException(`Atleta com ID ${id} não encontrado`);
    }

    return atleta;
  }

  async update(id: string, updateAtletaDto: UpdateAtletaDto): Promise<Atleta> {
    const atleta = await this.findOne(id);

    const { clubeAtualId, federacaoId, ...atletaData } = updateAtletaDto;

    // Se o clube atual mudou, criar histórico
    if (clubeAtualId && clubeAtualId !== atleta.clubeAtualId) {
      // Fechar histórico anterior se existir
      if (atleta.clubeAtualId) {
        const historicoAnterior = await this.historicoClubeRepository.findOne({
          where: {
            atletaId: id,
            clubeId: atleta.clubeAtualId,
            dataFim: null,
          },
        });
        if (historicoAnterior) {
          historicoAnterior.dataFim = new Date();
          await this.historicoClubeRepository.save(historicoAnterior);
        }
      }

      // Criar novo histórico
      const clube = await this.clubeRepository.findOne({
        where: { id: clubeAtualId },
      });
      if (clube) {
        const historico = this.historicoClubeRepository.create({
          atleta,
          clube,
          dataInicio: new Date(),
        });
        await this.historicoClubeRepository.save(historico);
        atleta.clubeAtual = clube;
        atleta.clubeAtualId = clubeAtualId;
      }
    }

    Object.assign(atleta, atletaData);
    return this.atletaRepository.save(atleta);
  }

  async remove(id: string): Promise<void> {
    const atleta = await this.findOne(id);
    await this.atletaRepository.remove(atleta);
  }

  async getHistorico(id: string): Promise<HistoricoClube[]> {
    const atleta = await this.findOne(id);
    return this.historicoClubeRepository.find({
      where: { atletaId: id },
      relations: ['clube'],
      order: { dataInicio: 'DESC' },
    });
  }
}


