<?php
declare (strict_types=1);

//Classe para verificação de usuarios através da autenticação 
// criação de sessão e cookies de navegador
final class AuthService {
    //atributo
    private const TEMPO_INATIVIDADE_SEG = 900; //15min

    //criar funções static => não precisa criar objeto => funções executas diretamente pela classe

    public static function iniciarSessaoSegura():void{
        if(session_start() === PHP_SESSION_NONE){ //verifica se a sessão ja existe 
            // se não existir => cria uma 
            // cria os parametros do cookie
            session_set_cookie_params([
                "lifetime"  => 0,
                "path"      => "/",
                "httponly"  => true,
                "samesite"  => "Lax"
            ]);
            //inicia session
            session_start();
        }
    }

    //Gravar os dados do usuario na sessão e gerar um identificador
    public static function autenticar(array $usuario): void{
        // iniciar a session
        self::iniciarSessaoSegura(); // criar 
        session_regenerate_id(true);

        //gravando na superglobal as informações do usuário conectado
        $_SESSION["usuario_id"]         = (int)$usuario["id"];
        $_SESSION["usuario_nome"]       = (string)$usuario["nome"];
        $_SESSION["usuario_email"]      = (string)$usuario["email"];
        $_SESSION["usuario_perfil"]     = (string)$usuario["perfil"];
        $_SESSION["ultimo_acesso"]      = time();

    }

    // verificação de tempo de inicatividade
    public static function verificarExpiracao(): bool {
        self::iniciarSessaoSegura();
        if(!isset($_SESSION["ultimo_acesso"])){
            return true;
        }
        if((time() - $_SESSION))
    }

    //destruir a session => 
}

