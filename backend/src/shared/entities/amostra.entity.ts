import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  JoinColumn,
  OneToOne,
  CreateDateColumn,
  UpdateDateColumn,
} from 'typeorm';
import { TesteAntidoping } from './teste-antidoping.entity';
import { Resultado } from './resultado.entity';

export enum TipoAmostra {
  A = 'A',
  B = 'B',
}

export enum StatusAmostra {
  PENDENTE = 'PENDENTE',
  ANALISADA = 'ANALISADA',
  POSITIVA = 'POSITIVA',
  NEGATIVA = 'NEGATIVA',
  INCONCLUSIVA = 'INCONCLUSIVA',
}

@Entity('amostras')
export class Amostra {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @ManyToOne(() => TesteAntidoping, (teste) => teste.amostras)
  @JoinColumn({ name: 'testeId' })
  teste: TesteAntidoping;

  @Column()
  testeId: string;

  @Column({
    type: 'enum',
    enum: TipoAmostra,
  })
  tipo: TipoAmostra;

  @Column({ unique: true })
  codigo: string; // Código único da amostra

  @Column({
    type: 'enum',
    enum: StatusAmostra,
    default: StatusAmostra.PENDENTE,
  })
  status: StatusAmostra;

  @OneToOne(() => Resultado, (resultado) => resultado.amostra, { nullable: true })
  resultado: Resultado;

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


