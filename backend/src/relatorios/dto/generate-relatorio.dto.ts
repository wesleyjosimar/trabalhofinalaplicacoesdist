import { IsOptional, IsUUID, IsDateString, IsEnum } from 'class-validator';

export enum TipoRelatorio {
  POR_ATLETA = 'POR_ATLETA',
  POR_COMPETICAO = 'POR_COMPETICAO',
  POR_CLUBE = 'POR_CLUBE',
  POR_PERIODO = 'POR_PERIODO',
  INDICADORES = 'INDICADORES',
}

export class GenerateRelatorioDto {
  @IsEnum(TipoRelatorio)
  tipo: TipoRelatorio;

  @IsOptional()
  @IsUUID()
  atletaId?: string;

  @IsOptional()
  @IsUUID()
  competicaoId?: string;

  @IsOptional()
  @IsUUID()
  clubeId?: string;

  @IsOptional()
  @IsDateString()
  dataInicio?: string;

  @IsOptional()
  @IsDateString()
  dataFim?: string;

  @IsOptional()
  formato?: string; // PDF, CSV, Excel
}


