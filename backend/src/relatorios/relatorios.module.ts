import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { RelatoriosController } from './relatorios.controller';
import { RelatoriosService } from './relatorios.service';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Atleta } from '../shared/entities/atleta.entity';

@Module({
  imports: [TypeOrmModule.forFeature([TesteAntidoping, Atleta])],
  controllers: [RelatoriosController],
  providers: [RelatoriosService],
  exports: [RelatoriosService],
})
export class RelatoriosModule {}


