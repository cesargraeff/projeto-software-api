<?php

namespace Curriculo\Middleware;

use PDO;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use Curriculo\Shared\Usuario;
use Curriculo\Exception\UnauthenticatedException;


class Authentication
{

    private $ci;
    
    private $db;

    private $settings;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->db = $ci->get('db');
        $this->settings = $ci->get('settings')['jwt'];
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        
        $jwt = $request->getHeader('HTTP_AUTHORIZATION');
        $jwt = str_replace("Bearer ","",$jwt[0]) ?? "";

        if($jwt){

            try{
                $jwt = JWT::decode($jwt,$this->settings['secret'],array('HS256'));

                $db = $this->db->prepare('SELECT * FROM vw_login WHERE id = ? and role = ?');
                $db->execute(array($jwt->id, $jwt->role));

                if($db->rowCount() == 1){
                    
                    $usuario = $db->fetch(PDO::FETCH_ASSOC);

                    $this->ci['usuario'] = new Usuario(
                        $usuario['id'],
                        $usuario['nome'],
                        $usuario['email'],
                        $usuario['permissao'],
                        $usuario['role']
                    );

                    return $next($request, $response);

                }else{
                    throw new UnauthenticatedException('Usuário não encontrado');
                }
            
            }catch(Exception $e){
                throw new UnauthenticatedException('Erro ao decodificar token');
            }

        }else{
            throw new UnauthenticatedException('Token de acesso não informado');
        }
        
    }

}