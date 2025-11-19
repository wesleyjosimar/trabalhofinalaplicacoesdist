import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  JoinColumn,
  CreateDateColumn,
  UpdateDateColumn,
  OneToMany,
} from 'typeorm';
import { Clube } from './clube.entity';
import { Federacao } from './federacao.entity';
import { TesteAntidoping } from './teste-antidoping.entity';
import { HistoricoClube } from './historico-clube.entity';

@Entity('atletas')
export class Atleta {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column()
  nome: string;

  @Column({ unique: true })
  documento: string; // CPF ou documento de identidade

  @Column({ type: 'date' })
  dataNascimento: Date;

  @ManyToOne(() => Clube, { nullable: true })
  @JoinColumn({ name: 'clubeAtualId' })
  clubeAtual: Clube;

  @Column({ nullable: true })
  clubeAtualId: string;

  @ManyToOne(() => Federacao)
  @JoinColumn({ name: 'federacaoId' })
  federacao: Federacao;

  @Column()
  federacaoId: string;

  @Column({ nullable: true })
  posicao: string; // goleiro, defensor, meio-campo, atacante

  @OneToMany(() => TesteAntidoping, (teste) => teste.atleta)
  testes: TesteAntidoping[];

  @OneToMany(() => HistoricoClube, (historico) => historico.atleta)
  historicoClubes: HistoricoClube[];

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


