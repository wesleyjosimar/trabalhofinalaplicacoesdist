import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  CreateDateColumn,
  Index,
} from 'typeorm';

export enum TipoEvento {
  CRIAÇÃO = 'CRIAÇÃO',
  ATUALIZAÇÃO = 'ATUALIZAÇÃO',
  EXCLUSÃO = 'EXCLUSÃO',
  REGISTRO_RESULTADO = 'REGISTRO_RESULTADO',
  SOLICITAÇÃO_REANÁLISE = 'SOLICITAÇÃO_REANÁLISE',
}

@Entity('auditoria')
@Index(['entidade', 'entidadeId'])
@Index(['usuarioId'])
@Index(['createdAt'])
export class Auditoria {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column()
  entidade: string; // 'TesteAntidoping', 'Resultado', 'Amostra', etc.

  @Column()
  entidadeId: string;

  @Column({
    type: 'enum',
    enum: TipoEvento,
  })
  tipoEvento: TipoEvento;

  @Column({ nullable: true })
  usuarioId: string;

  @Column({ nullable: true })
  usuarioEmail: string;

  @Column({ type: 'text', nullable: true })
  dadosAntigos: string; // JSON

  @Column({ type: 'text', nullable: true })
  dadosNovos: string; // JSON

  @Column({ type: 'text', nullable: true })
  observacoes: string;

  @CreateDateColumn()
  createdAt: Date;
}


