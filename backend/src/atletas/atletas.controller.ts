import {
  Controller,
  Get,
  Post,
  Body,
  Patch,
  Param,
  Delete,
  Query,
  UseGuards,
} from '@nestjs/common';
import { AtletasService } from './atletas.service';
import { CreateAtletaDto } from './dto/create-atleta.dto';
import { UpdateAtletaDto } from './dto/update-atleta.dto';
import { ListAtletasDto } from './dto/list-atletas.dto';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';
import { RolesGuard } from '../auth/guards/roles.guard';
import { Roles } from '../auth/decorators/roles.decorator';
import { PerfilUsuario } from '../shared/entities/usuario.entity';

@Controller('atletas')
@UseGuards(JwtAuthGuard)
export class AtletasController {
  constructor(private readonly atletasService: AtletasService) {}

  @Post()
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO)
  create(@Body() createAtletaDto: CreateAtletaDto) {
    return this.atletasService.create(createAtletaDto);
  }

  @Get()
  findAll(@Query() listAtletasDto: ListAtletasDto) {
    return this.atletasService.findAll(listAtletasDto);
  }

  @Get(':id')
  findOne(@Param('id') id: string) {
    return this.atletasService.findOne(id);
  }

  @Get(':id/historico')
  getHistorico(@Param('id') id: string) {
    return this.atletasService.getHistorico(id);
  }

  @Patch(':id')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF, PerfilUsuario.FEDERACAO)
  update(@Param('id') id: string, @Body() updateAtletaDto: UpdateAtletaDto) {
    return this.atletasService.update(id, updateAtletaDto);
  }

  @Delete(':id')
  @UseGuards(RolesGuard)
  @Roles(PerfilUsuario.CBF)
  remove(@Param('id') id: string) {
    return this.atletasService.remove(id);
  }
}


