import {
  Controller,
  Get,
  Post,
  Body,
  Param,
  Query,
  UseGuards,
  Request,
  BadRequestException,
} from '@nestjs/common';
import { IntegracaoService } from './integracao.service';
import { LaboratorioResultadoDto } from './dto/laboratorio-resultado.dto';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';
import { RolesGuard } from '../auth/guards/roles.guard';
import { Roles } from '../auth/decorators/roles.decorator';
import { PerfilUsuario } from '../shared/entities/usuario.entity';

@Controller('integracao')
export class IntegracaoController {
  constructor(private readonly integracaoService: IntegracaoService) {}

  @Post('laboratorio/resultado')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(PerfilUsuario.LABORATORIO)
  receberResultadoLaboratorio(
    @Body() resultadoDto: LaboratorioResultadoDto,
    @Request() req,
  ) {
    // Obter laboratorioId do token JWT (organizacaoId)
    const laboratorioId = req.user.organizacaoId;
    if (!laboratorioId) {
      throw new BadRequestException('Laboratório não identificado no token');
    }
    return this.integracaoService.receberResultadoLaboratorio(laboratorioId, resultadoDto);
  }

  @Get('regulador/testes')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(PerfilUsuario.REGULADOR)
  consultarTestes(
    @Query('atletaId') atletaId?: string,
    @Query('competicaoId') competicaoId?: string,
    @Query('dataInicio') dataInicio?: string,
    @Query('dataFim') dataFim?: string,
  ) {
    return this.integracaoService.consultarTestes({
      atletaId,
      competicaoId,
      dataInicio,
      dataFim,
    });
  }
}

