import {
  IsEnum,
  IsUUID,
  IsNotEmpty,
  IsDateString,
  IsString,
  IsOptional,
} from 'class-validator';
import { TipoResultado } from '../../shared/entities/resultado.entity';

export class CreateResultadoDto {
  @IsUUID()
  @IsNotEmpty()
  laboratorioId: string;

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


