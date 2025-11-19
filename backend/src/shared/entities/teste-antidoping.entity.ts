import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  JoinColumn,
  OneToMany,
  CreateDateColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Atleta } from './atleta.entity';
import { Competicao } from './competicao.entity';
import { Amostra } from './amostra.entity';

@Entity('testes_antidoping')
export class TesteAntidoping {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @ManyToOne(() => Atleta)
  @JoinColumn({ name: 'atletaId' })
  atleta: Atleta;

  @Column()
  atletaId: string;

  @ManyToOne(() => Competicao, { nullable: true })
  @JoinColumn({ name: 'competicaoId' })
  competicao: Competicao;

  @Column({ nullable: true })
  competicaoId: string;

  @Column({ type: 'timestamp' })
  dataColeta: Date;

  @Column()
  localColeta: string;

  @Column()
  coletor: string; // Nome ou ID do coletor

  @Column({ nullable: true })
  observacoes: string;

  @OneToMany(() => Amostra, (amostra) => amostra.teste)
  amostras: Amostra[];

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


