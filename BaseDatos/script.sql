CREATE DATABASE IF NOT EXISTS blogfotografiaTFG;
use blogfotografiaTFG;


CREATE TABLE IF NOT EXISTS `users`(
    `id`  int(255) auto_increment not null,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
    `telefono` int(9) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nombreUsuario` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
    `verificado` int(1) COLLATE utf8mb4_unicode_ci,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci,
    `admin` int(1) COLLATE utf8mb4_unicode_ci,
    `fotografo` int(1) COLLATE utf8mb4_unicode_ci,

    CONSTRAINT pk_users PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE IF NOT EXISTS `categorias`(
    `id`  int(255) auto_increment not null,
    `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,

    CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `reportajes`(
    `id`  int(255) auto_increment not null,
    `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
    `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `usersId` int(255) COLLATE utf8mb4_unicode_ci,
    `categoriaId` int(255) COLLATE utf8mb4_unicode_ci,
    

    CONSTRAINT pk_reportajes PRIMARY KEY(id),
    CONSTRAINT fk_users_id FOREIGN KEY(usersId) REFERENCES users(id),
    CONSTRAINT fk_categoria_id FOREIGN KEY(categoriaId) REFERENCES categorias(id)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `fotosReportajes`(
    `id`  int(255) auto_increment not null,
    `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `reportajeId` int(255) COLLATE utf8mb4_unicode_ci NOT NULL,

    CONSTRAINT pk_fotosReportajes PRIMARY KEY(id),
    CONSTRAINT fk_reportaje_id FOREIGN KEY(reportajeId) REFERENCES reportajes(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `informacionFotografo`(
    `id`  int(255) auto_increment not null,
    `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `userId` int(255) COLLATE utf8mb4_unicode_ci NOT NULL,

    CONSTRAINT pk_informacionFotografo PRIMARY KEY(id),
    CONSTRAINT fk_usuario_id FOREIGN KEY(userId) REFERENCES users(id)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;











