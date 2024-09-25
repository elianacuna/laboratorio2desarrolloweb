CREATE TABLE Clientes(
    codigo      int primary key auto_increment,
    nombre      varchar(150) not null,
    telefono    varchar(10),
    correo      varchar(100)
);

CREATE TABLE Producto(
    codigo      int primary key auto_increment,
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
    factura     int not null, --codigo de la tabla factura
    producto    int not null,
    cantidad    int not null,
    subtotal    double not null,
    foreign key (factura) references Factura(codigo),
    foreign key (producto) references Producto(codigo)
);

 
