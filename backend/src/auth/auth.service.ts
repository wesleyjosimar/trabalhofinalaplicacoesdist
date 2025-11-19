import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import * as bcrypt from 'bcrypt';
import { Usuario, PerfilUsuario } from '../shared/entities/usuario.entity';
import { LoginDto } from './dto/login.dto';

@Injectable()
export class AuthService {
  constructor(
    @InjectRepository(Usuario)
    private usuarioRepository: Repository<Usuario>,
    private jwtService: JwtService,
  ) {}

  async validateUser(email: string, senha: string): Promise<any> {
    const usuario = await this.usuarioRepository.findOne({
      where: { email, ativo: true },
    });

    if (usuario && (await bcrypt.compare(senha, usuario.senha))) {
      const { senha: _, ...result } = usuario;
      return result;
    }
    return null;
  }

  async login(loginDto: LoginDto) {
    const usuario = await this.validateUser(loginDto.email, loginDto.senha);
    if (!usuario) {
      throw new UnauthorizedException('Credenciais inválidas');
    }

    const payload = {
      sub: usuario.id,
      email: usuario.email,
      perfil: usuario.perfil,
      organizacaoId: usuario.organizacaoId,
    };

    return {
      access_token: this.jwtService.sign(payload),
      usuario: {
        id: usuario.id,
        email: usuario.email,
        perfil: usuario.perfil,
        nome: usuario.nome,
        organizacaoId: usuario.organizacaoId,
      },
    };
  }

  async createUser(
    email: string,
    senha: string,
    perfil: PerfilUsuario,
    nome?: string,
    organizacaoId?: string,
  ): Promise<Usuario> {
    const hashedPassword = await bcrypt.hash(senha, 10);
    const usuario = this.usuarioRepository.create({
      email,
      senha: hashedPassword,
      perfil,
      nome,
      organizacaoId,
    });
    return this.usuarioRepository.save(usuario);
  }
}


