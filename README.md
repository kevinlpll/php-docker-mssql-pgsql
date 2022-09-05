#PHP rodando PHP 8.10 com drivers de conexão para MSSQL e PGSQL

Para a conexão com os bancos, o servidor PHP precisa de algumas extensões. A conexão com SQL Server e Postgresql <b>NÃO</b> são recursos nativos. Os componentes de instalação estão contidos no "Dockerfile"

O postgresql só funciona se tiver o driver ODBCC da microsoft instalado https://github.com/Microsoft/msphpsql

Para o SQL Server funcionar, é necessário que ele esteja aceitando conexões via TCP/IP
https://www.apesoftware.com/calibration-control/help/sql-remote-connections

Para "Buildar" a imagem, rode o comando
$ docker build -t meu_php:latest .

Após esse processo, é possível rodar a imagem com o comando:
$ docker run -d -p 5000:80 meu_php:latest --name nome_do_container A ordem das portas do parâmetro -p é: Porta externa da maquina -> Porta do container

Também dá pra fazer o processo rodando o comando

$ docker compose up

Cada alteração no código é necessário um "Rebuild" da imagem
