<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function getById(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni where id= '$args[id]'");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function createAlunno(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = $request -> getBody()->getContents();
    $parsedBody = json_decode($body, true);
    $nome =$parsedBody['nome'];
    $cognome =$parsedBody['cognome'];
    $result = $mysqli_connection->query("INSERT into alunni (nome,cognome) VALUES ('$nome','$cognome')");
    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function updateAlunno(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = $request -> getBody()->getContents();
    $parsedBody = json_decode($body, true);
    $nome =$parsedBody['nome'];
    $cognome =$parsedBody['cognome'];
    $result = $mysqli_connection->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome' WHERE id = '$args[id]'");
    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function deleteAlunno(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result =$mysqli_connection->query("DELETE from alunni where id = $id");
    $response ->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }


}
