import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AntidopingController } from './antidoping.controller';
import { AntidopingService } from './antidoping.service';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Amostra } from '../shared/entities/amostra.entity';
import { Resultado } from '../shared/entities/resultado.entity';
import { Atleta } from '../shared/entities/atleta.entity';
import { Competicao } from '../shared/entities/competicao.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';
import { Auditoria } from '../shared/entities/auditoria.entity';
import { AtletasModule } from '../atletas/atletas.module';

@Module({
  imports: [
    TypeOrmModule.forFeature([
      TesteAntidoping,
      Amostra,
      Resultado,
      Atleta,
      Competicao,
      Laboratorio,
      Auditoria,
    ]),
    AtletasModule,
  ],
  controllers: [AntidopingController],
  providers: [AntidopingService],
  exports: [AntidopingService],
})
export class AntidopingModule {}


