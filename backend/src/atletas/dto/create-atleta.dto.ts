import {
  IsString,
  IsNotEmpty,
  IsDateString,
  IsUUID,
  IsOptional,
} from 'class-validator';

export class CreateAtletaDto {
  @IsString()
  @IsNotEmpty()
  nome: string;

  @IsString()
  @IsNotEmpty()
  documento: string;

  @IsDateString()
  @IsNotEmpty()
  dataNascimento: string;

  @IsUUID()
  @IsNotEmpty()
  federacaoId: string;

  @IsUUID()
  @IsOptional()
  clubeAtualId?: string;

  @IsString()
  @IsOptional()
  posicao?: string;
}


