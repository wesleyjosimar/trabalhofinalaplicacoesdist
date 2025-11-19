import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AtletasController } from './atletas.controller';
import { AtletasService } from './atletas.service';
import { Atleta } from '../shared/entities/atleta.entity';
import { Clube } from '../shared/entities/clube.entity';
import { Federacao } from '../shared/entities/federacao.entity';
import { HistoricoClube } from '../shared/entities/historico-clube.entity';

@Module({
  imports: [TypeOrmModule.forFeature([Atleta, Clube, Federacao, HistoricoClube])],
  controllers: [AtletasController],
  providers: [AtletasService],
  exports: [AtletasService],
})
export class AtletasModule {}


