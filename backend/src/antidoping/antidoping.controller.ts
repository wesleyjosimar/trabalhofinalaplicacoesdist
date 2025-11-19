import {
  Controller,
  Get,
  Post,
  Patch,
  Body,
  Param,
  Query,
  UseGuards,
  Request,
} from '@nestjs/common';
import { AntidopingService } from './antidoping.service';
import { CreateTesteDto } from './dto/create-teste.dto';
import { CreateAmostraDto } from './dto/create-amostra.dto';
import { CreateResultadoDto } from './dto/create-resultado.dto';
import { UpdateAmostraStatusDto } from './dto/update-amostra-status.dto';
import { ListTestesDto } from './dto/list-testes.dto';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';
import { RolesGuard } from '../auth/guards/roles.guard';
import { Roles } from '../auth/decorators/roles.decorator';
import { PerfilUsuario } from '../shared/entities/usuario.entity';

@Controller('antidoping')
@UseGuards(JwtAuthGuard)
export class AntidopingController {
  constructor(private readonly antidopingService: AntidopingService) {}

  @Post('testes')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO)
  createTeste(@Body() createTesteDto: CreateTesteDto, @Request() req) {
    return this.antidopingService.createTeste(
      createTesteDto,
      req.user.id,
      req.user.email,
    );
  }

  @Get('testes')
  findAllTestes(@Query() listTestesDto: ListTestesDto) {
    return this.antidopingService.findAllTestes(listTestesDto);
  }

  @Get('testes/:id')
  findOneTeste(@Param('id') id: string) {
    return this.antidopingService.findOneTeste(id);
  }

  @Post('testes/:id/amostras')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO)
  createAmostra(
    @Param('id') id: string,
    @Body() createAmostraDto: CreateAmostraDto,
    @Request() req,
  ) {
    return this.antidopingService.createAmostra(
      id,
      createAmostraDto,
      req.user.id,
      req.user.email,
    );
  }

  @Post('amostras/:id/resultado')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.LABORATORIO)
  createResultado(
    @Param('id') id: string,
    @Body() createResultadoDto: CreateResultadoDto,
    @Request() req,
  ) {
    return this.antidopingService.createResultado(
      id,
      createResultadoDto,
      req.user.id,
      req.user.email,
    );
  }

  @Get('amostras/:id/custodia')
  getCadeiaCustodia(@Param('id') id: string) {
    return this.antidopingService.getCadeiaCustodia(id);
  }

  @Post('testes/:id/reanalise')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO)
  solicitarReanalise(@Param('id') id: string, @Request() req) {
    return this.antidopingService.solicitarReanalise(id, req.user.id, req.user.email);
  }

  @Patch('amostras/:id/status')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO, PerfilUsuario.LABORATORIO)
  updateAmostraStatus(
    @Param('id') id: string,
    @Body() updateStatusDto: UpdateAmostraStatusDto,
    @Request() req,
  ) {
    return this.antidopingService.updateAmostraStatus(
      id,
      updateStatusDto,
      req.user.id,
      req.user.email,
    );
  }
}


