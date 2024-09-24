CREATE TABLE Clientes(
    codigo      int primary key auto_increment,
    nombre      varchar(150) not null,
    telefono    varchar(10),
    correo      varchar(100)
);

CREATE TABLE Producto(
    codigo      int primary key,
    descripcion varchar(250) not null,
    observaciones varchar(255),
    precio      double not null
);

CREATE TABLE Factura(
    codigo      int primary key auto_increment,
    cliente     int not null,
    fecha       date,
    monto       double,
    foreign key (cliente) references Clientes(codigo)
);

CREATE TABLE Detalle_Factura(
    id          int primary key auto_increment,
    factura     int not null,
    producto    int not null,
    cantidad    int not null,
    subtotal    double not null,
    foreign key (factura) references Factura(codigo),
    foreign key (producto) references Producto(codigo)
);

-- Ahora puedes proceder a hacer las consultas e inserciones.

insert into clientes(nombre,telefono,correo) values('axel aguilar','12345678','mail.123@mail.com');

select * from clientes;

truncate table clientes;
Select codigo, nombre, telefono, correo from Clientes;

delete from clientes where codigo<6;
desc producto;
insert into producto 
values(1,'Martillo de Madera','Martillo pequeño de Madera',19.99);
select codigo,descripcion,precio,observaciones from producto;

-- insert a maestro
desc factura;
select * from clientes;
INSERT INTO factura(cliente,fecha,monto)
values(1,now(),0);

-- insert en el detalle del maestro
select * from factura;
select * from producto;
desc detalle_factura;
insert into detalle_factura(factura,producto,cantidad,subtotal)
values(1,2,1,35.5*1);

select df.id, df.factura,df.producto,p.descripcion,df.cantidad,df.subtotal from detalle_factura df
inner join producto p on p.codigo=df.producto
where factura=1;

select * 
from factura f
inner join clientes c on c.codigo=f.cliente
inner join detalle_factura df on df.factura=f.codigo
inner join producto p on p.codigo=df.producto
where f.codigo=1;

 
