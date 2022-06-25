# Jornal Web - Colégio Chimbanda

Este é um site ficticio construido para _fins de estudo_ para gerenciar as noticias do **Colégio Chimbanda**, foi criado nos finais de `dezembro de 2020` para exercitar o `PHP`, principlamente assuntos ligados a `arquitetura e POO`, hoje percebo que na época eu não entendia absolutamente NADA sobre nem um nem outro, é só ver o quanto a arquitetura e o código do projeto estão SUJOS😅, apesar de tudo não tenciono alterar nenhuma linha de código desse projeto, foram os meus primeiros passos na linguagem `PHP` e não quero apagá-los, quero puder vê-los e me divertir com isso sempre que quiser. "VER" A MINHA PRÓPRIA EVOLUÇÃO É FASCINANTE.❤

# Pré-requisitos para rodar o sistema localmente
Por ser um projeto ficticio não me preocupei em hospedá-lo, mas caso queiras ver o projeto rodando, eis abaixo alguns elementos que precisas ter instalado em sua máquina.

1. Servidor APACHE e MySQL (para instalar podes usar o XAMPP ou aplicativos similares)
2. Algum Navegador (Óbvio😅)

# Passos para rodar o projeto localmente

Com essas ferramentas instaladas o próximo passo é clonar o repositório:
```
git clone https://github.com/Francisco-Fetapi/site-jornal-web.git
```

Com o repositório clonado basta apenas importar o banco de dados com suas respetivas tabelas no seu _gestor de banco de dados_, no exemplo a seguir estarei usando o **PHPMyAdmin**

![importando_bd](https://user-images.githubusercontent.com/74926014/175775785-c8792c9a-6d77-425d-b222-292519af9954.PNG)

Ao acessar o painel para importar um __banco de dados__ deve-se escolher o arquivo com as instruções a serem executadas para criar o banco. Na raiz do projeto clonado temos o arquivo `jornal_web.sql`, é ele que contém todo o SQL que deve ser executado para criar o banco de dados e suas respetivas tabelas.

Quase que ia me esquecendo: O projeto clonado deve ser movido para a pasta onde o endereço `http://localhost` aponta, no meu caso, já que estou usando o `XAMPP` o endereço é `C:\xampp\htdocs`. Depois da pasta ser movida para o local designado no passo anterior, ao acessar `http://localhost/site-jornal-web` acessaremos o sistema, como se segue nas imagens abaixo:

![1](https://user-images.githubusercontent.com/74926014/175776086-11d6517c-9efd-44d4-8f83-e131d574bd1e.PNG)
![2](https://user-images.githubusercontent.com/74926014/175776103-1359ccfe-0d5a-4455-8f34-205cb2556082.PNG)
![3](https://user-images.githubusercontent.com/74926014/175776119-16e28d94-9039-443f-94ee-a38ff874ef40.PNG)

##

Se seguiu todos os passos acima já pode acessar o site <a href="http://localhost/site-jornal-web">clicando aqui</a>
