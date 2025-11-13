import { IsOptional, IsString, IsDateString, IsUUID } from 'class-validator';

export class UpdateAtletaDto {
  @IsOptional()
  @IsString()
  nome?: string;

  @IsOptional()
  @IsString()
  documento?: string;

  @IsOptional()
  @IsDateString()
  dataNascimento?: string;

  @IsOptional()
  @IsUUID()
  federacaoId?: string;

  @IsOptional()
  @IsUUID()
  clubeAtualId?: string;

  @IsOptional()
  @IsString()
  posicao?: string;
}
