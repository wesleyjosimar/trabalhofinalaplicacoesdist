import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  OneToOne,
  JoinColumn,
  CreateDateColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Amostra } from './amostra.entity';
import { Laboratorio } from './laboratorio.entity';

export enum TipoResultado {
  NEGATIVO = 'NEGATIVO',
  POSITIVO = 'POSITIVO',
  INCONCLUSIVO = 'INCONCLUSIVO',
}

@Entity('resultados')
export class Resultado {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @OneToOne(() => Amostra, (amostra) => amostra.resultado)
  @JoinColumn({ name: 'amostraId' })
  amostra: Amostra;

  @Column()
  amostraId: string;

  @ManyToOne(() => Laboratorio)
  @JoinColumn({ name: 'laboratorioId' })
  laboratorio: Laboratorio;

  @Column()
  laboratorioId: string;

  @Column({
    type: 'enum',
    enum: TipoResultado,
  })
  resultado: TipoResultado;

  @Column({ type: 'text', nullable: true })
  detalhes: string;

  @Column({ type: 'timestamp' })
  dataAnalise: Date;

  @Column({ nullable: true })
  substanciaEncontrada: string;

  @Column({ nullable: true })
  concentracao: string;

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


