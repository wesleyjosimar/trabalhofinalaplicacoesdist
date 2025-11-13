import { IsEnum, IsString, IsOptional } from 'class-validator';
import { TipoAmostra } from '../../shared/entities/amostra.entity';

export class CreateAmostraDto {
  @IsEnum(TipoAmostra)
  tipo: TipoAmostra;

  @IsString()
  @IsOptional()
  codigo?: string;
}


