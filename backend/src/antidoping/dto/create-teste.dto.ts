import {
  IsString,
  IsNotEmpty,
  IsUUID,
  IsOptional,
  IsDateString,
} from 'class-validator';

export class CreateTesteDto {
  @IsUUID()
  @IsNotEmpty()
  atletaId: string;

  @IsUUID()
  @IsOptional()
  competicaoId?: string;

  @IsDateString()
  @IsNotEmpty()
  dataColeta: string;

  @IsString()
  @IsNotEmpty()
  localColeta: string;

  @IsString()
  @IsNotEmpty()
  coletor: string;

  @IsString()
  @IsOptional()
  observacoes?: string;
}


