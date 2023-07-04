create database pit;
use pit;
create table user (
	user_id int primary key not null auto_increment,
    nome varchar(40) not null,
    email varchar(120) not null,
    senha varchar(254) not null,
    telefone varchar(15),
    endereco varchar(120),
    verify_cod varchar(5) not null
);

create table piscina (
	piscina_id int primary key not null auto_increment,
    nome varchar(80) not null,
    largura float not null,
    altura float not null,
    comprimento float not null,
    proximaLimpeza date,
    ultimaLimpeza date,
    fk_user_id int not null,
    foreign key (fk_user_id) references User(user_id)
);