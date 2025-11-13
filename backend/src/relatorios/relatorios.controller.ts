import { Controller, Get, Post, Body, Param, UseGuards } from '@nestjs/common';
import { RelatoriosService } from './relatorios.service';
import { GenerateRelatorioDto } from './dto/generate-relatorio.dto';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';

@Controller('relatorios')
@UseGuards(JwtAuthGuard)
export class RelatoriosController {
  constructor(private readonly relatoriosService: RelatoriosService) {}

  @Post('gerar')
  generateRelatorio(@Body() generateRelatorioDto: GenerateRelatorioDto) {
    return this.relatoriosService.generateRelatorio(generateRelatorioDto);
  }

  @Get(':id')
  getRelatorioStatus(@Param('id') id: string) {
    return this.relatoriosService.getRelatorioStatus(id);
  }

  @Get(':id/download')
  downloadRelatorio(@Param('id') id: string) {
    return this.relatoriosService.downloadRelatorio(id);
  }
}


