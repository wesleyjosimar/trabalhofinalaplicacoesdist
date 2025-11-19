import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  JoinColumn,
  CreateDateColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Federacao } from './federacao.entity';

@Entity('competicoes')
export class Competicao {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column()
  nome: string;

  @Column({ type: 'date', nullable: true })
  dataInicio: Date;

  @Column({ type: 'date', nullable: true })
  dataFim: Date;

  @Column({ nullable: true })
  tipo: string; // campeonato, copa, torneio

  @ManyToOne(() => Federacao)
  @JoinColumn({ name: 'federacaoId' })
  federacao: Federacao;

  @Column()
  federacaoId: string;

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


