drop database if exists WSERS2_R;
create database WSERS2_R;

use WSERS2_R;

create table CarsDb(
    ModelIdCar int not null auto_increment primary key,
    ModelName varchar(100),
    Price int not null,
    Available int not null
);

create table Orders(
    OrderId int not null auto_increment primary key,
    ClientName varchar(50) not null,
    ModelIdOrdered int not null,
    NumberOfCarsOrdered int not null,
    FOREIGN KEY (ModelIdOrdered) REFERENCES CarsDb(ModelIdCar)
);


create view CarsView as 
select ModelIdCar,ModelName,Price,Available,SUM(NumberOfCarsOrdered) as Ordered from carsdb 
left join orders on carsdb.ModelIdCar = orders.ModelIdOrdered group by ModelIdCar;


insert into CarsDb (ModelName,Price,Available) VALUES ("Dacia",10000,100),("Volvo",50000,30),("BMW",60000,40),("Renault",20000,80),("Tata motors",5000,5);

insert into Orders (ClientName,ModelIdOrdered,NumberOfCarsOrdered) VALUES ("John",1,54);
insert into Orders (ClientName,ModelIdOrdered,NumberOfCarsOrdered) VALUES ("Dan",1,22);
insert into Orders (ClientName,ModelIdOrdered,NumberOfCarsOrdered) VALUES ("Angela",5,25);
