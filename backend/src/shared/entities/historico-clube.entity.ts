import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  ManyToOne,
  JoinColumn,
  CreateDateColumn,
} from 'typeorm';
import { Atleta } from './atleta.entity';
import { Clube } from './clube.entity';

@Entity('historico_clubes')
export class HistoricoClube {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @ManyToOne(() => Atleta)
  @JoinColumn({ name: 'atletaId' })
  atleta: Atleta;

  @Column()
  atletaId: string;

  @ManyToOne(() => Clube)
  @JoinColumn({ name: 'clubeId' })
  clube: Clube;

  @Column()
  clubeId: string;

  @Column({ type: 'date' })
  dataInicio: Date;

  @Column({ type: 'date', nullable: true })
  dataFim: Date;

  @CreateDateColumn()
  createdAt: Date;
}


