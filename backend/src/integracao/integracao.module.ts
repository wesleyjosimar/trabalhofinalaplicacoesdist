import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { IntegracaoController } from './integracao.controller';
import { IntegracaoService } from './integracao.service';
import { Resultado } from '../shared/entities/resultado.entity';
import { Amostra } from '../shared/entities/amostra.entity';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';

@Module({
  imports: [TypeOrmModule.forFeature([Resultado, Amostra, TesteAntidoping, Laboratorio])],
  controllers: [IntegracaoController],
  providers: [IntegracaoService],
  exports: [IntegracaoService],
})
export class IntegracaoModule {}


