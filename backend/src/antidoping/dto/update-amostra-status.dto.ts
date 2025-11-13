import { IsEnum } from 'class-validator';
import { StatusAmostra } from '../../shared/entities/amostra.entity';

export class UpdateAmostraStatusDto {
  @IsEnum(StatusAmostra)
  status: StatusAmostra;
}

