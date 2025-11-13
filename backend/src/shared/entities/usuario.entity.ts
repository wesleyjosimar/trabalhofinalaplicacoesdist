import {
  Entity,
  PrimaryGeneratedColumn,
  Column,
  CreateDateColumn,
  UpdateDateColumn,
} from 'typeorm';

export enum PerfilUsuario {
  CBF = 'CBF',
  FEDERACAO = 'FEDERACAO',
  CLUBE = 'CLUBE',
  LABORATORIO = 'LABORATORIO',
  REGULADOR = 'REGULADOR',
}

@Entity('usuarios')
export class Usuario {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column({ unique: true })
  email: string;

  @Column()
  senha: string; // hash bcrypt

  @Column({
    type: 'enum',
    enum: PerfilUsuario,
  })
  perfil: PerfilUsuario;

  @Column({ nullable: true })
  nome: string;

  @Column({ nullable: true })
  organizacaoId: string; // ID da federação, clube ou laboratório associado

  @Column({ default: true })
  ativo: boolean;

  @CreateDateColumn()
  createdAt: Date;

  @UpdateDateColumn()
  updatedAt: Date;
}


