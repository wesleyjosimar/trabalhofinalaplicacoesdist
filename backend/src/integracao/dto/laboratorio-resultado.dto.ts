import {
  IsString,
  IsNotEmpty,
  IsEnum,
  IsDateString,
  IsOptional,
} from 'class-validator';
import { TipoResultado } from '../../shared/entities/resultado.entity';

export class LaboratorioResultadoDto {
  @IsString()
  @IsNotEmpty()
  codigoAmostra: string;

  @IsEnum(TipoResultado)
  @IsNotEmpty()
  resultado: TipoResultado;

  @IsDateString()
  @IsNotEmpty()
  dataAnalise: string;

  @IsString()
  @IsOptional()
  detalhes?: string;

  @IsString()
  @IsOptional()
  substanciaEncontrada?: string;

  @IsString()
  @IsOptional()
  concentracao?: string;
}


