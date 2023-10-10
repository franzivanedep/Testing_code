-- Create database for student
create database student_db;
use student_db;

CREATE TABLE student (
  `id_num` int(30) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `program` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `year` int(30) NOT NULL,
  `password`varchar(45) NOT NULL,
  PRIMARY KEY  (`id_num`)
);

-- Create database for professors
CREATE DATABASE professor_db;
USE professor_db;

-- Create table for professors
CREATE TABLE professors (
  `id_num` int(30) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `age` int(30) NOT NULL,
  `department` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password`varchar(45) NOT NULL,
  PRIMARY KEY  (`id_num`)
);

-- Create database for faculty
CREATE DATABASE faculty_db;
USE faculty_db;

-- Create table for faculty
CREATE TABLE faculty (
  `id_num` int(30) NOT NULL,
  `first name` varchar(45) NOT NULL,
  `last name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `department` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `year` int(30) NOT NULL,
  `password`varchar(45) NOT NULL,
  PRIMARY KEY  (`id_num`)
);


-- Create the database
CREATE DATABASE item_db;
USE item_db;

-- Create the table for items
CREATE TABLE items (
  `id_num` int(30) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `quantity` int(30) NOT NULL,
  `category` varchar(45) NOT NULL,
  PRIMARY KEY  (`id_num`)
);
