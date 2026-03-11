drop database if exists auto_ecole;
create database auto_ecole;
use auto_ecole;

create table user (
    id_user int auto_increment,
    email varchar(100) not null unique,
    mdp varchar(100) not null,
    nom varchar(50) not null,
    prenom varchar(50) not null,
    role varchar(20) not null,
    constraint pk_user primary key (id_user)
);

create table candidat (
    id_candidat int auto_increment,
    nomC varchar(50) not null,
    prenomC varchar(50) not null,
    date_naissanceC DATE not null,
    adresseC varchar(100),
    telephoneC varchar(15),
    date_inscription date not null,
    statut enum('En formation', 'Examen en cours', 'Diplome', 'Abandonne') default 'En formation',
    constraint pk_candidat primary key (id_candidat)
);

create table moniteur (
    id_moniteur int auto_increment,
    nomM varchar(50) not null,
    prenomM varchar(50) not null,
    emailM varchar(100) not null unique,
    telephoneM varchar(15),
    date_embauche DATE not null,
    constraint pk_moniteur primary key (id_moniteur)
);

create table vehicule (
    id_vehicule int auto_increment,
    immat varchar(20) not null unique,
    date_Achat date not null,
    nb_km int not null,
    energie varchar(20) not null,
    marque varchar(50) not null,
    modele varchar(50) not null,
    type_vehicule VARCHAR(50),
    constraint pk_vehicule primary key (id_vehicule)
);

create table lecon (
    id_lecon int auto_increment,
    id_candidat int,
    id_moniteur int,
    id_vehicule int,
    date_lecon datetime not null,
    libelle varchar(100),
    duree_lecon int not null,
    compterendu text,
    constraint pk_lecon primary key (id_lecon),
    foreign key (id_candidat) references candidat(id_candidat) on delete cascade,
    foreign key (id_moniteur) references moniteur(id_moniteur),
    foreign key (id_vehicule) references vehicule(id_vehicule)
);

create table examen (
    id_examen int auto_increment,
    id_candidat int not null,
    id_moniteur int,
    id_vehicule int,
    type_examen varchar(50) not null,
    lieu_examen varchar(100),
    date_examen datetime not null,
    resultat enum('En attente', 'Reussi', 'Echoue') default 'En attente',
    remarques text,
    constraint pk_examen primary key (id_examen),
    foreign key (id_candidat) references candidat(id_candidat) on delete cascade,
    foreign key (id_moniteur) references moniteur(id_moniteur),
    foreign key (id_vehicule) references vehicule(id_vehicule)
);

insert into user values (null, 'admin@admin.fr', 'adminpass', 'Admin', 'Système', 'admin');
