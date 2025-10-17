-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-10-2025 a las 04:53:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `BibliotecaDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Blog`
--

CREATE TABLE `Blog` (
  `id_blog` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Blog`
--

INSERT INTO `Blog` (`id_blog`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(5, 'sasdasfasfa', '<p>fasfasfaf</p>', 'img/blog/blog_68d87b8184b7f.png', '2025-09-27 19:04:17'),
(6, '2', '<p>dasd</p>', 'blog_68d890160f1d5.png', '2025-09-27 20:32:06'),
(7, '3', '<p>ads</p>', 'blog_68d89051e6abd.png', '2025-09-27 20:33:05'),
(8, '4', '<p>dasd</p>', 'Libro4.jpg', '2025-09-27 20:38:22'),
(9, 'hyhy', '<p>dasdaf</p>', 'img/blog/blog_68d89247a1ec5.png', '2025-09-27 20:41:27'),
(10, 'dd', '<p>dsds</p>', 'img/blog/blog_68d892e57d6b5.png', '2025-09-27 20:44:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias_Programas`
--

CREATE TABLE `Categorias_Programas` (
  `id_categoriaPrograma` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Categorias_Programas`
--

INSERT INTO `Categorias_Programas` (`id_categoriaPrograma`, `nombre`, `id_programa`) VALUES
(1, 'Gestion empresarial', 1),
(2, 'Marketing y ventas', 1),
(3, 'Finanzas', 1),
(4, 'Auditoria', 2),
(5, 'Contabilidad General', 2),
(6, 'Finanzas y tributacion', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Descargas`
--

CREATE TABLE `Descargas` (
  `id_descarga` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ejemplares`
--

CREATE TABLE `Ejemplares` (
  `id_ejemplar` int(11) NOT NULL,
  `id_libro` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Ejemplares`
--

INSERT INTO `Ejemplares` (`id_ejemplar`, `id_libro`, `estado`) VALUES
(1, 1, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Libros`
--

CREATE TABLE `Libros` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `autor` varchar(50) DEFAULT NULL,
  `anio_salida` int(11) DEFAULT NULL,
  `portada` varchar(200) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `descripcionBreve` varchar(100) DEFAULT NULL,
  `archivo` varchar(200) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoriaPrograma` int(11) DEFAULT NULL,
  `mas_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Libros`
--

INSERT INTO `Libros` (`id_libro`, `titulo`, `autor`, `anio_salida`, `portada`, `descripcion`, `descripcionBreve`, `archivo`, `stock`, `id_categoriaPrograma`, `mas_pedido`) VALUES
(1, 'Administración: una perspectiva global y empresarial', 'no c', 2024, 'img/categorias/administracion de empresas/gestion empresarial/Administración: una perspectiva global y empresarial.jpeg', 'este libro', 's', 'n', 41, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Multas`
--

CREATE TABLE `Multas` (
  `id_multa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_prestamo` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('pendiente','pagada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Noticias`
--

CREATE TABLE `Noticias` (
  `id_noticia` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Noticias`
--

INSERT INTO `Noticias` (`id_noticia`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'mdddddddd', 'dssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 'https://blog.hubspot.es/hubfs/media/contabilidad-basica.jpg', '2025-09-18'),
(2, 'njksf', 'asasasad', 'https://blog.hubspot.es/hubfs/media/contabilidad-basica.jpg', '2025-09-16'),
(3, 'dsdsfsf', 'danakkfj', 'https://blog.hubspot.es/hubfs/media/contabilidad-basica.jpg', '2025-09-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Prestamos`
--

CREATE TABLE `Prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` varchar(50) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Prestamos`
--

INSERT INTO `Prestamos` (`id_prestamo`, `fecha_inicio`, `fecha_devolucion`, `id_usuario`, `estado`, `fecha_solicitud`, `id_libro`) VALUES
(10, '2025-10-05', NULL, 1, 'activo', '2025-10-05 13:16:07', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Prestamo_Ejemplar`
--

CREATE TABLE `Prestamo_Ejemplar` (
  `id_prestamo` int(11) NOT NULL,
  `id_ejemplar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Programas`
--

CREATE TABLE `Programas` (
  `id_programa` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcionBreve` varchar(350) NOT NULL,
  `portada` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Programas`
--

INSERT INTO `Programas` (`id_programa`, `nombre`, `descripcion`, `descripcionBreve`, `portada`) VALUES
(1, 'Administracion de empresas', 'El Programa de administracion de empresas forma profesionales técnicos con competencias en la constitución, organización y supervisión de procesos empresariales, con énfasis en producción, comercialización, finanzas y gestión de recursos humanos. La carrera desarrolla en el estudiante capacidades para identificar oportunidades de negocio, gestionar emprendimientos, promover la innovación y aplicar buenas prácticas empresariales, con un enfoque ético, colaborativo y orientado a la mejora continua.', 'Encuentra recursos sobre gestión, liderazgo, marketing y planificación estratégica', 'img/carrerasPortadas/administracionDeEmpresas.jpg'),
(2, 'Contabilidad', 'El Programa de Contabilidad forma profesionales técnicos capaces de desarrollar operaciones contables y financieras, así como formular, analizar y supervisar estados financieros de entidades públicas y privadas, de acuerdo con los principios y normas de información financiera vigentes. La carrera potencia en el estudiante el uso de tecnologías de la información y del idioma inglés como apoyo en sus funciones profesionales. Asimismo, promueve la ética, la innovación, el emprendimiento, el liderazgo y el trabajo en equipo, preparando egresados capaces de brindar soluciones efectivas e innovadoras a los procesos contables, productivos y de servicios.', 'Accede a textos sobre finanzas, auditoría, tributación y gestión contable', 'img/carrerasPortadas/contabilidad.jpg'),
(3, 'Desarrollo de sistemas', 'El Programa de Desarrollo de Sistemas de Información forma profesionales técnicos capaces de analizar, diseñar, desarrollar, implementar, gestionar y dar soporte a sistemas informáticos, aplicaciones móviles y videojuegos, aplicando buenas prácticas de programación y políticas de seguridad. El egresado domina herramientas tecnológicas y el idioma inglés como apoyo a sus actividades, se comunica de manera efectiva y se caracteriza por su ética profesional, capacidad para resolver problemas, liderazgo e innovación. Está preparado para desempeñarse en entidades públicas, privadas o en emprendimientos propios, aportando soluciones tecnológicas innovadoras que optimizan los procesos productivos y de servicios.', 'Libros de programación, bases de datos, inteligencia artificial y desarrollo web', 'img/carrerasPortadas/desarrolloDeSistemas.jpg'),
(4, 'Electricidad industrial', 'Técnico en Electricidad Industrial con competencias para instalar sistemas eléctricos de baja, media y alta tensión, máquinas electromecánicas, automatización industrial, redes y conectividad. Capacitado para gestionar sistemas de control industrial y electrónica de potencia, aplicando criterios de eficiencia energética, análisis de riesgos, estándares de seguridad y normativa vigente. Destaca por su ética, comunicación efectiva y capacidad para resolver problemas mediante soluciones innovadoras. Maneja inglés y tecnologías de la información como soporte en su labor, aportando liderazgo, emprendimiento y trabajo en equipo en el ámbito industrial.', 'Recursos sobre circuitos, mantenimiento, seguridad eléctrica y automatización', 'img/carrerasPortadas/electricidadIndustrial.jpg'),
(5, 'Electrónica Industrial', 'Técnico en Electrónica Industrial con competencias para instalar e implementar sistemas de conducción de energía eléctrica y comunicaciones, así como equipos eléctricos y electrónicos de configuración básica en edificaciones e industrias, de acuerdo con planos, demanda de carga y normativa de seguridad vigente. Se distingue por su ética, comunicación efectiva y capacidad para identificar problemas y proponer soluciones. Maneja tecnologías de la información e inglés como soporte en su labor, y aporta innovación, liderazgo, emprendimiento y trabajo en equipo en los procesos productivos y de servicios.', 'Encuentra libros de electrónica digital, microcontroladores y sistemas embebidos', 'img/carrerasPortadas/electronicaIndustrial.jpg'),
(6, 'Enfermería Técnica', 'El Programa de Enfermería Técnica con competencias para promover y prevenir la salud integral de la persona, familia y comunidad en los diferentes niveles de atención a lo largo del ciclo vital, respetando los derechos, la legislación vigente y los procedimientos institucionales. Se caracteriza por su ética, comunicación efectiva y capacidad para identificar problemas y proponer soluciones. Utiliza el inglés y las tecnologías de la información como apoyo en su labor, destacando por su liderazgo, innovación, emprendimiento y trabajo en equipo en el ámbito de la salud.', 'Libros de anatomía, farmacología, primeros auxilios y técnicas clínicas', 'img/carrerasPortadas/enfermeriaTecnica.jpg'),
(7, 'Tecnología de Análisis Químico', 'El Programa de Tecnología de Análisis Químico con competencias para la toma, preparación y almacenamiento de muestras, así como para seleccionar métodos y realizar análisis de materias primas, materiales en proceso y productos terminados según protocolos y normativas vigentes. Destaca por su ética, comunicación efectiva, manejo de tecnologías de la información e inglés aplicado a su labor. Posee capacidad para identificar problemas, proponer soluciones innovadoras y desempeñarse en entidades públicas, privadas o en emprendimientos propios, aportando liderazgo, trabajo en equipo y mejora continua en los procesos productivos y de servicios.', 'Explora manuales de química, laboratorios, seguridad y análisis instrumental', 'img/carrerasPortadas/tecnologiaDeAnalisisQuimico.jpeg'),
(8, 'Cocina', 'Técnico en Cocina con competencias para aplicar técnicas culinarias y gestionar procesos de adquisición, almacenamiento, preparación y presentación de alimentos y bebidas, cumpliendo protocolos y normativas de buenas prácticas de manipulación. Se distingue por su ética, comunicación efectiva y capacidad para identificar problemas y proponer soluciones innovadoras en los procesos gastronómicos. Maneja inglés y herramientas tecnológicas como apoyo en su labor, destacando por su emprendimiento, liderazgo y trabajo en equipo colaborativo.', 'Descubre libros de gastronomía, técnicas culinarias y arte de la cocina internacional', 'img/carrerasPortadas/cocina.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidoPaterno` varchar(30) NOT NULL,
  `apellidoMaterno` varchar(30) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id_usuario`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `correo`, `tipo`, `contraseña`, `foto`) VALUES
(1, 'juan ', 'guzman', 'guerra', 'juanguz619@gmail.com', 'estudiante', '1234', 'img/carrerasPortadas/AdministracionDeEmpresas.jpg'),
(2, 'Nauj', 'Guerra', 'Guzman', 'naujGuerra@gmail.com', 'admin', '1234', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Blog`
--
ALTER TABLE `Blog`
  ADD PRIMARY KEY (`id_blog`);

--
-- Indices de la tabla `Categorias_Programas`
--
ALTER TABLE `Categorias_Programas`
  ADD PRIMARY KEY (`id_categoriaPrograma`),
  ADD KEY `Categorias_Programas_ibfk_1` (`id_programa`);

--
-- Indices de la tabla `Descargas`
--
ALTER TABLE `Descargas`
  ADD PRIMARY KEY (`id_descarga`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `Ejemplares`
--
ALTER TABLE `Ejemplares`
  ADD PRIMARY KEY (`id_ejemplar`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `Libros`
--
ALTER TABLE `Libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoriaPrograma` (`id_categoriaPrograma`);

--
-- Indices de la tabla `Multas`
--
ALTER TABLE `Multas`
  ADD PRIMARY KEY (`id_multa`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_prestamo` (`id_prestamo`);

--
-- Indices de la tabla `Noticias`
--
ALTER TABLE `Noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `Prestamos`
--
ALTER TABLE `Prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `Prestamo_Ejemplar`
--
ALTER TABLE `Prestamo_Ejemplar`
  ADD PRIMARY KEY (`id_prestamo`,`id_ejemplar`),
  ADD KEY `id_ejemplar` (`id_ejemplar`);

--
-- Indices de la tabla `Programas`
--
ALTER TABLE `Programas`
  ADD PRIMARY KEY (`id_programa`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Blog`
--
ALTER TABLE `Blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Ejemplares`
--
ALTER TABLE `Ejemplares`
  MODIFY `id_ejemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Libros`
--
ALTER TABLE `Libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Multas`
--
ALTER TABLE `Multas`
  MODIFY `id_multa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Prestamos`
--
ALTER TABLE `Prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Categorias_Programas`
--
ALTER TABLE `Categorias_Programas`
  ADD CONSTRAINT `Categorias_Programas_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `Programas` (`id_programa`);

--
-- Filtros para la tabla `Descargas`
--
ALTER TABLE `Descargas`
  ADD CONSTRAINT `Descargas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`),
  ADD CONSTRAINT `Descargas_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `Libros` (`id_libro`);

--
-- Filtros para la tabla `Ejemplares`
--
ALTER TABLE `Ejemplares`
  ADD CONSTRAINT `Ejemplares_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `Libros` (`id_libro`);

--
-- Filtros para la tabla `Libros`
--
ALTER TABLE `Libros`
  ADD CONSTRAINT `Libros_ibfk_1` FOREIGN KEY (`id_categoriaPrograma`) REFERENCES `Categorias_Programas` (`id_categoriaPrograma`);

--
-- Filtros para la tabla `Multas`
--
ALTER TABLE `Multas`
  ADD CONSTRAINT `Multas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`),
  ADD CONSTRAINT `Multas_ibfk_2` FOREIGN KEY (`id_prestamo`) REFERENCES `Prestamos` (`id_prestamo`);

--
-- Filtros para la tabla `Prestamos`
--
ALTER TABLE `Prestamos`
  ADD CONSTRAINT `Prestamos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`),
  ADD CONSTRAINT `Prestamos_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `Libros` (`id_libro`);

--
-- Filtros para la tabla `Prestamo_Ejemplar`
--
ALTER TABLE `Prestamo_Ejemplar`
  ADD CONSTRAINT `Prestamo_Ejemplar_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `Prestamos` (`id_prestamo`),
  ADD CONSTRAINT `Prestamo_Ejemplar_ibfk_2` FOREIGN KEY (`id_ejemplar`) REFERENCES `Ejemplares` (`id_ejemplar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
