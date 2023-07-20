-- Active: 1689701985754@@127.0.0.1@5432@didae@sae
DROP TABLE IF EXISTS sae.propietario;
DROP TABLE IF EXISTS sae.estatus_arma_denuncia;
DROP TABLE IF EXISTS sae.registro_procedimiento_arma;
DROP TABLE IF EXISTS sae.arma_recuperada;
DROP TABLE IF EXISTS sae.persona_denuncia;
DROP TABLE IF EXISTS sae.archivo;
DROP TABLE IF EXISTS sae.persona;
DROP TABLE IF EXISTS sae.denuncia;
DROP TABLE IF EXISTS sae.hecho;
DROP TABLE IF EXISTS sae.direccion;

DROP TABLE IF EXISTS sae.arma;
DROP TABLE IF EXISTS sae.municipio;
DROP TABLE IF EXISTS sae.departamento;
DROP TABLE IF EXISTS sae.item;
DROP TABLE IF EXISTS sae.categoria;


-- ================================================
-- Catalogo / (Primer Modulo denuncia)
-- ================================================


CREATE TABLE sae.categoria(
                            id_categoria SERIAL PRIMARY KEY,
                            descripcion VARCHAR(128)
);

INSERT INTO sae.categoria(id_categoria,descripcion)
VALUES
  (1,'Nacionalidad'), --listo
  (2,'Genero'), --listo
  (3,'Tipo arma'), --listo
  (4,'Marca arma'), --listo
  (5,'Tipo denuncia'), --listo
  (6,'Tipo incautacion'), --listo
  (7,'Calibre'), --listo
  (8,'Pais de fabricacion'), --listo
  (9,'Estado arma'), --listo
  (10,'Tipo direccion'), --listo
  (11,'Tipo propietario'), --listo
  (12,'Demarcacion'), --listo
  (13,'Tipo persona'), --listo
  (14,'Tipo procedimiento'), --listo
  (15,'Tipo hecho'),
  (16,'Estado denuncia'), --Listo
  (17,'Tipo documento') --listo
;


-- ===============================================
-- Items / (Primer Modulo denuncia)
-- ===============================================

CREATE TABLE sae.item(
                       id_item SERIAL PRIMARY KEY,
                       descripcion VARCHAR(128),
                       id_categoria INT,
                       FOREIGN KEY (id_categoria) REFERENCES sae.categoria(id_categoria)
);


INSERT INTO sae.item(id_item,descripcion,id_categoria)
VALUES
  (1,'Guatemalteca',1),
  (2,'Masculino',2),
  (3,'Femenino',2),
  (4,'Pistola',3),
  (5,'Revolver',3),
  (6,'Escopeta',3),
  (7,'Fúsil',3),
  (8,'Subametralladora',3),
  (9,'Ametralladora',3),
  (10,'Traumatica',3),
  -- (11,'Hechiza',3),
  (12,'Hechiza',3),
  (13,'Heckler & Koch (HK).',4),
  (14,'Walther',4),
  (15,'SIG-Sauer',4),
  (16,'Star (desaparecida).',4),
  (17,'GLOCK',4),
  (18,'Beretta',4),
  (19,'Fabrique Nationale de Herstal (FN).',4),
  (20,'Česká zbrojovka (CZ).',4),
  (21,'Astra-llama',4),
  (22,'Browning',4),
  (23,'Colt',4),
  (24,'Ruger',4),
  (25,'Smith & Wesson',4),
  (26,'Carl Walther',4),
  (27,'Heckler & Koch',4),
  (28,'Mauser-Werke',4),
  (29,'Sauer',4),
  (30,'Feinwerkbau',4),
  (31,'Bersa',4),
  (32,'Fabricaciones Militares',4),
  (33,'Ballester Molina (cerró en 1953).',4),
  (34,'Rexio',4),
  (35,'Tala (cerró).',4),
  (36,'Armas Antiguas Osvaldo Gatto',4),
  (37,'Glock GmbH',4),
  (38,'Steyr-Mannlicher GmbH & Co',4),
  (39,'Taurus',4),
  (40,'Rossi',4),
  (41,'Fabrique Nationale de Herstal (FN).',4),
  (42,'Para-Ordnance Mfg.Inc.',4),
  (43,'INDUMIL (Industria Militar).',4),
  (44,'FAMAE',4),
  (45,'Industrias Cardoen',4),
  (46,'Daewoo',4),
  (47,'F.M. Santa Bárbara',4),
  (48,'Grand Power s.r.o.',4),
  (49,'Llama Gabilondo y Cía. S.A.(ya no existe) (Éibar).',4),
  (50,'SPS - DC Custom Armeros S.L. (Barcelona).',4),
  (51,'STAR, Bonifacio Echeverría S.A. (ya no existe) (Éibar).',4),
  (52,'Santa Bárbara Sistemas.',4),
  (53,'Víctor Sarasqueta (Éibar).',4),
  (54,'Laurona (Éibar).',4),
  (55,'AYA (Aguirre y Aranzábal) (Éibar).',4),
  (56,'Ignacio Zubillaga (Éibar).',4),
  (57,'Galbasoro (Éibar).',4),
  (58,'Pedro Aranguren (Éibar).',4),
  (59,'ALFA (Éibar).',4),
  (60,'Domingo Aranguren (Éibar).',4),
  (61,'Antonio Lisundia (Éibar).',4),
  (62,'Eusebio Zuloaga (Éibar).',4),
  (63,'Ramón Zuloaga (Éibar).',4),
  (64,'Pablo Juaristi (Éibar).',4),
  (65,'Orbea Hermanos (Éibar).',4),
  (66,'Reales Fábricas de Placencia de las Armas (Placencia de las Armas).',4),
  (67,'José Aguirre e Ignacio Bustindui (Éibar).',4),
  (68,'Gárate Anitua y Cía',4),
  (69,'Arcadia Machine & Tool (AMT)',4),
  (70,'Bryco Arms (cerró por bancarrota)',4),
  (71,'Browning Arms Company',4),
  (72,'Colts Manufacturing Company LLC',4),
  (73,'Davis Industries',4),
  (74,'Jennings Firearms (cerró por bancarrota)',4),
  (75,'Jiménez Arms',4),
  (76,'Lorcin Engineering Comapny',4),
  (77,'Hi-Point Firearms',4),
  (78,'Phoenix Arms',4),
  (79,'Raven Arms',4),
  (80,'Ruger',4),
  (81,'Savage Arms Corporation',4),
  (82,'Smith & Wesson',4),
  (83,'Springfield Armory',4),
  (84,'STI',4),
  (85,'Sundance Industries',4),
  (86,'SVI (Infinity)',4),
  (87,'Manufacture d Armes de Saint-Etienne (MAS).',4),
  (88,'Manufacture d Armes de Châtellerault (MAC)',4),
  (89,'Manufacture d Armes de Toulouse (MAT)',4),
  (90,'Manufacture d Armes Automatiques de Bayonne',4),
  (91,'Manufacture du Haut-Rhin (Manurhin).',4),
  (92,'Sako Tikka',4),
  (93,'Fegyuver es Gepgyar (FEG).',4),
  (94,'B. Bernardelli s.r.a.',4),
  (95,'Fabbrica d Armi Pietro Beretta S.p.A.',4),
  (96,'Fratelli Tanfoglio SpA.',4),
  (97,'Rino-Galesi-Rigarmi-Brescia',4),
  (98,'Matchguns (Cesare Morini).',4),
  (99,'Benelli Armi',4),
  (100,'Israel Military Industries (IMI).',4),
  (101,'Productos Mendoza',4),
  (102,'Armas Trejo',4),
  (103,'Prexer Ltd.',4),
  (104,'Z.M. Łucznik Zakłady Metalowe Łucznik S.A.',4),
  (105,'Moravia Arms',4),
  (106,'Česká zbrojovka (CZ).',4),
  (107,'Strojirna s.r.o.',4),
  (108,'Izhmek Izhevsky Mekhanichesky Zavod',4),
  (109,'Makarov PM',4),
  (110,'Tokarev',4),
  (111,'Husqvarna Vapenfabrik (hasta 1970).',4),
  (112,'Försvarets Fabriksverk (FFV).',4),
  (113,'Schweizerishe Industrie Gesellschaft (SIG).',4),
  (114,'Sphinx Systems Ltd.',4),
  (115,'Hammerli',4),
  (116,'Morini Arms',4),
  (117,'Trabzon Arms Industry Corp.',4),
  (118,'CAVIM Industrias Militares.',4),
  (119,'Robo',5),
  (120,'Hurto',5),
  (121,'Extravio',5),
  (122,'4',7),
  (123,'8',7),
  (124,'10',7),
  (125,'12',7),
  (126,'16',7),
  (127,'20',7),
  (128,'24',7),
  (129,'28',7),
  (130,'32',7),
  (131,'36',7),
  (132,'410',7),
  (133,'. 257 Roberts',7),
  (134,'.17 Águila',7),
  (135,'.17 HMR',7),
  (136,'.17 Mach 2',7),
  (137,'.17 Remington',7),
  (138,'.17 Remington Fireball',7),
  (139,'.22 Corto',7),
  (140,'.22 Eargesplitten Loudenboomer',7),
  (141,'.22 Extra Long',7),
  (142,'.22 Hornet',7),
  (143,'.22 Long',7),
  (144,'.22 Long Rifle',7),
  (145,'.22 Savage Hi-Power',7),
  (146,'.22 TCM',7),
  (147,'.22 Winchester Magnum Rimfire',7),
  (148,'.22-250 Remington',7),
  (149,'.25 ACP',7),
  (150,'.25 Winchester Super Short Magnum',7),
  (151,'.25-06 Remington',7),
  (152,'.25-20 Winchester',7),
  (153,'.30 Carbine',7),
  (154,'.30 Newton',7),
  (155,'.30 Remington',7),
  (156,'.30-03 Springfield',7),
  (157,'.30-06 Springfield',7),
  (158,'.30-30 Winchester',7),
  (159,'.30-40 Krag',7),
  (160,'.30-378 Weatherby Magnum',7),
  (161,'.32 H&R Magnum',7),
  (162,'.32 S&W',7),
  (163,'.32-20 Winchester',7),
  (164,'.35 Remington',7),
  (165,'.35 Whelen',7),
  (166,'.38 ACP',7),
  (167,'.38 S&W',7),
  (168,'.38 Special',7),
  (169,'.38 Super',7),
  (170,'.40 S&W',7),
  (171,'.41 AE',7),
  (172,'.41 Remington Magnum',7),
  (173,'.44 Bull Dog',7),
  (174,'.225 Winchester',7),
  (175,'.240 Apex',7),
  (176,'.240 Weatherby Magnum',7),
  (177,'.243 Winchester',7),
  (178,'.243 Winchester Super Short Magnum',7),
  (179,'.244 Holland & Holland Magnum',7),
  (180,'.250-3000 Savage',7),
  (181,'.256 Newton',7),
  (182,'.257 Weatherby Magnum',7),
  (183,'.260 Remington',7),
  (184,'.264 Winchester Magnum',7),
  (185,'.270 Weatherby Magnum',7),
  (186,'.270 Winchester',7),
  (187,'.270 Winchester Short Magnum',7),
  (188,'.275 Holland & Holland Magnum',7),
  (189,'.275 No 2 Magnum',7),
  (190,'.276 Pedersen',7),
  (191,'.277 Fury',7),
  (192,'.280 British',7),
  (193,'.280 Jeffery',7),
  (194,'.280 Remington',7),
  (195,'.280 Ross',7),
  (196,'.284 Winchester',7),
  (197,'.300 Holland & Holland Magnum',7),
  (198,'.300 Lapua Magnum',7),
  (199,'.300 Remington Ultra Magnum',7),
  (200,'.300 Ruger Compact Magnum',7),
  (201,'.300 Savage',7),
  (202,'.300 Weatherby Magnum',7),
  (203,'.300 Winchester Magnum',7),
  (204,'.300 Winchester Short Magnum',7),
  (205,'.303 British',7),
  (206,'.307 Winchester',7),
  (207,'.308 Marlin Express',7),
  (208,'.308 Norma Magnum',7),
  (209,'.308 Winchester',7),
  (210,'.333 Jeffery',7),
  (211,'.338 Federal',7),
  (212,'.338 Remington Ultra Magnum',7),
  (213,'.338 Ruger Compact Magnum',7),
  (214,'.338 Winchester Magnum',7),
  (215,'.338-378 Weatherby Magnum',7),
  (216,'.340 Weatherby Magnum',7),
  (217,'.350 Legend',7),
  (218,'.350 Remington Magnum',7),
  (219,'.357 Magnum',7),
  (220,'.357 SIG',7),
  (221,'.375 Dakota',7),
  (222,'.375 Holland & Holland Magnum',7),
  (223,'.375 Ruger',7),
  (224,'.375 Weatherby Magnum',7),
  (225,'.378 Weatherby Magnum',7),
  (226,'.400 Holland & Holland Magnum',7),
  (227,'.400/360 Nitro Express',7),
  (228,'.404 Jeffery',7),
  (229,'.416 Remington Magnum',7),
  (230,'.416 Rigby',7),
  (231,'.416 Ruger',7),
  (232,'.416 Weatherby Magnum',7),
  (233,'.450 Bushmaster',7),
  (234,'.450 Nitro Express',7),
  (235,'.450 Rigby',7),
  (236,'.450/400 Nitro Express',7),
  (237,'.454 Casull',7),
  (238,'.458 Lott',7),
  (239,'.458 Winchester Magnum',7),
  (240,'.460 S&W Magnum',7),
  (241,'.460 Weatherby Magnum',7),
  (242,'.465 H&H Magnum',7),
  (243,'.465 Holland & Holland Magnum',7),
  (244,'.470 Nitro Express',7),
  (245,'.475 Nitro Express',7),
  (246,'.475 No 2 Nitro Express',7),
  (247,'.500 Jeffery',7),
  (248,'.500 Nitro Express',7),
  (249,'.500 S&W Magnum',7),
  (250,'.500/450 Nitro Express',7),
  (251,'.500/465 Nitro Express',7),
  (252,'.505 Gibbs',7),
  (253,'.577 Nitro Express',7),
  (254,'.577 Tyrannosaur',7),
  (255,'.600 Nitro Express',7),
  (256,'.700 Nitro Express',7),
  (257,'0–9',7),
  (258,'2 mm Kolibri',7),
  (259,'2,34 mm Rimfire',7),
  (260,'3 mm Kolibri',7),
  (261,'4 mm Randz Court',7),
  (262,'4 mm Randz Long',7),
  (263,'4.25 mm Erika Auto',7),
  (264,'5 mm Remington Magnum Rimfire',7),
  (265,'5 mm/35 SMc',7),
  (266,'5,7 × 28 mm',7),
  (267,'5,45 × 18 mm',7),
  (268,'5,45 × 39 mm',7),
  (269,'5,56 × 45 mm',7),
  (270,'5,8 × 42 mm',7),
  (271,'6 mm Flobert',7),
  (272,'6,5 × 50 mm Arisaka',7),
  (273,'6,5 × 52 mm Mannlicher-Carcano',7),
  (274,'6,8 mm Remington SPC',7),
  (275,'6.5-284 Norma',7),
  (276,'6.5-300 Weatherby Magnum',7),
  (277,'6.5×47mm Lapua',7),
  (278,'6.5×54mm Mannlicher–Schönauer',7),
  (279,'6.5×55mm Sueco',7),
  (280,'6.5mm Creedmoor',7),
  (281,'6.8 Western',7),
  (282,'6mm Lee Navy',7),
  (283,'6mm Remington',7),
  (284,'7 × 57 mm Mauser',7),
  (285,'7 mm Remington Magnum',7),
  (286,'7,5 × 54 mm Francés',7),
  (287,'7,7 × 58 mm Arisaka',7),
  (288,'7,35 × 51 mm Carcano',7),
  (289,'7,62 × 25 mm Tokarev',7),
  (290,'7,62 × 39 mm',7),
  (291,'7,62 × 45 mm vz. 52',7),
  (292,'7,62 × 51 mm OTAN',7),
  (293,'7,62 × 54 mm R',7),
  (294,'7,63 × 25 mm Mauser',7),
  (295,'7,65 × 17 mm Browning',7),
  (296,'7,65 × 21 mm Parabellum',7),
  (297,'7,65 × 25 mm Borchardt',7),
  (298,'7,65 × 53 mm Mauser',7),
  (299,'7,92 × 33 mm Kurz',7),
  (300,'7,92 × 57 mm',7),
  (301,'7mm Remington Short Action Ultra Magnum',7),
  (302,'7mm Remington Ultra Magnum',7),
  (303,'7mm Shooting Times Westerner',7),
  (304,'7mm Weatherby Magnum',7),
  (305,'7mm Winchester Short Magnum',7),
  (306,'7mm-08 Remington',7),
  (307,'8 × 22 mm Nambu',7),
  (308,'8 mm Lebel',7),
  (309,'8mm Remington Magnum',7),
  (310,'9 × 17 mm Corto',7),
  (311,'9 × 18 mm Makarov',7),
  (312,'9 × 19 mm Parabellum',7),
  (313,'9 × 39 mm',7),
  (314,'9 mm Glisenti',7),
  (315,'9 x 23 mm',7),
  (316,'9.3×62mm',7),
  (317,'10 mm Auto',7),
  (318,'12,7 × 99 mm OTAN',7),
  (319,'12,7 × 108 mm',7),
  (320,'13,2x92SR',7),
  (321,'14,5 × 114 mm',7),
  (322,'.55 Boys',7),
  (323,'Alemania',8),
  (324,'Argentina',8),
  (325,'Austria',8),
  (326,'Bangladés',8),
  (327,'Bélgica',8),
  (328,'Brasil',8),
  (329,'Bulgaria',8),
  (330,'Canadá',8),
  (331,'Chile',8),
  (332,'China',8),
  (333,'Colombia',8),
  (334,'Corea del Sur',8),
  (335,'Croacia',8),
  (336,'Egipto',8),
  (337,'Emiratos Árabes Unidos',8),
  (338,'Eslovaquia',8),
  (339,'Eslovenia',8),
  (340,'España',8),
  (341,'Estados Unidos',8),
  (342,'Filipinas',8),
  (343,'Finlandia',8),
  (344,'Francia',8),
  (345,'Grecia',8),
  (346,'Hungría',8),
  (347,'Israel',8),
  (348,'Italia',8),
  (349,'Japón',8),
  (350,'México',8),
  (351,'Montenegro',8),
  (352,'Pakistán',8),
  (353,'Perú',8),
  (354,'Polonia',8),
  (355,'Reino Unido',8),
  (356,'República Checa',8),
  (357,'Rumania',8),
  (358,'Rusia',8),
  (359,'Serbia',8),
  (360,'Singapur',8),
  (361,'Suecia',8),
  (362,'Suiza',8),
  (363,'Turquía',8),
  (364,'Ucrania',8),
  (365,'Venezuela',8),
  (366,'Residencia',10),
  (367,'Hecho',10),
  (368,'Incautacion',10),
  (369,'Particular',11),
  (370,'Privada',11),
  (371,'Comisaria 11, Guatemala',12),
  (372,'Comisaria 12, Guatemala',12),
  (373,'Comisaria 13, Guatemala',12),
  (374,'Comisaria 14, Guatemala',12),
  (375,'Comisaria 15, Guatemala',12),
  (376,'Comisaria 16, Guatemala',12),
  (377,'Comisaria 21 Jutiapa ',12),
  (378,'Comisaria 22 Jalapa',12),
  (379,'Comisaria 23 Chiquimula',12),
  (380,'Comisaria 24 Zacapa',12),
  (381,'Comisaria 31 Escuintla',12),
  (382,'Comisaria 32 Santa Rosa',12),
  (383,'Comisaria 33 Suchitepéquez',12),
  (384,'Comisaria 34 Retalhuleu',12),
  (385,'Comisaria 41 Quetzaltenango',12),
  (386,'Comisaria 42 San Marcos',12),
  (387,'Comisaria 43 Huehuetenango',12),
  (388,'Comisaria 44 Totonicapán',12),
  (389,'Comisaria 51 Cobán',12),
  (390,'Comisaria 52 Salamá',12),
  (391,'Comisaria 53 El Progreso',12),
  (392,'Comisaria 61 Izabal',12),
  (393,'Comisaria 62 Peten ',12),
  (394,'Comisaria 71 Quiché',12),
  (395,'Comisaria  72 Sololá',12),
  (396,'Comisaria 73 Chimaltenango',12),
  (397,'Comisaria 74 Sacatepéquez',12),
  (398,'Robada',9),
  (399,'Extraviada',9),
  (400,'Hurtada',9),
  (401,'Recuperada',9),
  (402,'Solvente',9),
  (403,'Sindicado',13),
  (404,'Denunciante',13),
  (405,'Detenido',13),
  (406,'Flagrancia',6),
  (407,'Allanamiento',6),
  (408,'Requiza',6),
  (409,'Orden de captura',6),
  (410,'Desalojo',6),
  (411,'Hallazgo',6),
  (412,'Recuperacion',6),
  (413,'Hallazgo',6),
  (414,'Sindicado',10),
  (415,'Registro de incautacion',14),
  (416,'Registro de denuncia',14),
  (417,'Registro de recuperacion',14),
  (418,'Registro de ampliacion',14),
  (419,'Diligencia',17), --Corregir
  (420,'Oficio',17), --Corregir
  (421,'Prevencion',17), --Corregir
  (422,'En cola',16),
  (423,'En proceso',16),
  (424,'Procesada',16)
;

-- ===============================================
-- Tabla Departamento
-- ===============================================
CREATE TABLE sae.departamento(
                               id_departamento SERIAL PRIMARY KEY,
                               departamento VARCHAR
);

INSERT INTO sae.departamento(id_departamento,departamento)
VALUES
  (1,'Guatemala'),
  (2,'Alta Verapaz'),
  (3,'Baja Verapaz'),
  (4,'Chimaltenango'),
  (5,'Chiquimula'),
  (6,'El Progreso'),
  (7,'Escuintla'),
  (8,'Huehuetenango'),
  (9,'Izabal'),
  (10,'Jalapa'),
  (11,'Jutiapa'),
  (12,'Petén'),
  (13,'Quetzaltenango'),
  (14,'Quiché'),
  (15,'Retalhuleu'),
  (16,'Sacatepequez'),
  (17,'San Marcos'),
  (18,'Santa Rosa'),
  (19,'Sololá'),
  (20,'Suchitepequez'),
  (21,'Totonicapán'),
  (22,'Zacapa')
;
-- ===============================================
-- Tabla Municipio
-- ===============================================
CREATE TABLE sae.municipio(
                            id_municipio SERIAL PRIMARY KEY,
                            municipio VARCHAR,
                            id_departamento INT,
                            FOREIGN KEY (id_departamento)  REFERENCES sae.departamento(id_departamento)
);

INSERT INTO sae.municipio(id_municipio,municipio,id_departamento)
VALUES

  (1,'Santa Catarina Pinula','1'),
  (2,'San José Pinula.','1'),
  (3,'Guatemala','1'),
  (4,'San José del Golfo','1'),
  (5,'Palencia','1'),
  (6,'Chinautla','1'),
  (7,'San Pedro Ayampuc','1'),
  (8,'Mixco','1'),
  (9,'San Pedro Sacatapéquez','1'),
  (10,'San Juan Sacatepéquez','1'),
  (11,'Chuarrancho','1'),
  (12,'San Raymundo','1'),
  (13,'Fraijanes','1'),
  (14,'Amatitlán','1'),
  (15,'Villa Nueva','1'),
  (16,'Villa Canales','1'),
  (17,'San Miguel Petapa','1'),
  (18,'Cobán','2'),
  (19,'Santa Cruz Verapaz','2'),
  (20,'San Cristóbal Verapaz','2'),
  (21,'Tactic','2'),
  (22,'Tamahú','2'),
  (23,'San Miguel Tucurú','2'),
  (24,'Panzóz','2'),
  (25,'Senahú.','2'),
  (26,'San Pedro Carchá','2'),
  (27,'San Juan Chamelco','2'),
  (28,'San Agustín Lanquín','2'),
  (29,'Santa María Cahabón','2'),
  (30,'Chisec','2'),
  (31,'Chahal','2'),
  (32,'Fray Bartolomé de las Casas','2'),
  (33,'Santa Catalina La Tinta','2'),
  (34,'Raxruhá','2'),
  (35,'Salamá','3'),
  (36,'San Miguel Chicaj','3'),
  (37,'Rabinal','3'),
  (38,'Cubulco','3'),
  (39,'Granados','3'),
  (40,'Santa Cruz el Chol','3'),
  (41,'San Jerónimo','3'),
  (42,'Purulhá','3'),
  (43,'Chimaltenango','4'),
  (44,'San José Poaquil','4'),
  (45,'San Martín Jilotepeque','4'),
  (46,'San Juan Comalapa','4'),
  (47,'Santa Apolonia','4'),
  (48,'Tecpán','4'),
  (49,'Patzún','4'),
  (50,'San Miguel Pochuta','4'),
  (51,'Patzicía','4'),
  (52,'Santa Cruz Balanyá','4'),
  (53,'Acatenango','4'),
  (54,'San Pedro Yepocapa','4'),
  (55,'San Andrés Itzapa','4'),
  (56,'Parramos','4'),
  (57,'Zaragoza','4'),
  (58,'El Tejar','4'),
  (59,'Chiquimula','5'),
  (60,'Jocotán','5'),
  (61,'Esquipulas','5'),
  (62,'Camotán','5'),
  (63,'Quezaltepeque','5'),
  (64,'Olopa','5'),
  (65,'Ipala','5'),
  (66,'San Juan Ermita','5'),
  (67,'Concepción Las Minas','5'),
  (68,'San Jacinto','5'),
  (69,'San José la Arada','5'),
  (70,'El Jícaro','6'),
  (71,'Morazán','6'),
  (72,'San Agustín Acasaguastlán','6'),
  (73,'San Antonio La Paz','6'),
  (74,'San Cristóbal Acasaguastlán','6'),
  (75,'Sanarate','6'),
  (76,'Guastatoya','6'),
  (77,'Sansare','6'),
  (78,'Escuintla','7'),
  (79,'Santa Lucía Cotzumalguapa','7'),
  (80,'La Democracia','7'),
  (81,'Siquinalá','7'),
  (82,'Masagua','7'),
  (83,'Tiquisate','7'),
  (84,'La Gomera','7'),
  (85,'Guaganazapa','7'),
  (86,'San José','7'),
  (87,'Iztapa','7'),
  (88,'Palín','7'),
  (89,'San Vicente Pacaya','7'),
  (90,'Nueva Concepción','7'),
  (91,'Huehuetenango','8'),
  (92,'Chiantla','8'),
  (93,'Malacatancito','8'),
  (94,'Cuilco','8'),
  (95,'Nentón','8'),
  (96,'San Pedro Necta','8'),
  (97,'Jacaltenango','8'),
  (98,'Soloma','8'),
  (99,'Ixtahuacán','8'),
  (100,'Santa Bárbara','8'),
  (101,'La Libertad','8'),
  (102,'La Democracia','8'),
  (103,'San Miguel Acatán','8'),
  (104,'San Rafael La Independencia','8'),
  (105,'Todos Santos Cuchumatán','8'),
  (106,'San Juan Atitlán','8'),
  (107,'Santa Eulalia','8'),
  (108,'San Mateo Ixtatán','8'),
  (109,'Colotenango','8'),
  (110,'San Sebastián Huehuetenango','8'),
  (111,'Tectitán','8'),
  (112,'Concepción Huista','8'),
  (113,'San Juan Ixcoy','8'),
  (114,'San Antonio Huista','8'),
  (115,'Santa Cruz Barillas','8'),
  (116,'San Sebastián Coatán','8'),
  (117,'Aguacatán','8'),
  (118,'San Rafael Petzal','8'),
  (119,'San Gaspar Ixchil','8'),
  (120,'Santiago Chimaltenango','8'),
  (121,'Santa Ana Huista','8'),
  (122,'Morales','9'),
  (123,'Los Amates','9'),
  (124,'Livingston','9'),
  (125,'El Estor','9'),
  (126,'Puerto Barrios','9'),
  (127,'Jalapa','10'),
  (128,'San Pedro Pinula','10'),
  (129,'San Luis Jilotepeque','10'),
  (130,'San Manuel Chaparrón','10'),
  (131,'San Carlos Alzatate','10'),
  (132,'Monjas','10'),
  (133,'Mataquescuintla','10'),
  (134,'Jutiapa','11'),
  (135,'El Progreso','11'),
  (136,'Santa Catarina Mita','11'),
  (137,'Agua Blanca','11'),
  (138,'Asunción Mita','11'),
  (139,'Yupiltepeque','11'),
  (140,'Atescatempa','11'),
  (141,'Jerez','11'),
  (142,'El Adelanto','11'),
  (143,'Zapotitlán','11'),
  (144,'Comapa','11'),
  (145,'Jalpatagua','11'),
  (146,'Conguaco','11'),
  (147,'Moyuta','11'),
  (148,'Pasaco','11'),
  (149,'Quesada','11'),
  (150,'Flores','12'),
  (151,'San José','12'),
  (152,'San Benito','12'),
  (153,'San Andrés','12'),
  (154,'La Libertad','12'),
  (155,'San Francisco','12'),
  (156,'Santa Ana','12'),
  (157,'Dolores','12'),
  (158,'San Luis','12'),
  (159,'Sayaxché','12'),
  (160,'Melchor de Mencos','12'),
  (161,'Poptún','12'),
  (162,'Quetzaltenango','13'),
  (163,'Salcajá','13'),
  (164,'San Juan Olintepeque','13'),
  (165,'San Carlos Sija','13'),
  (166,'Sibilia','13'),
  (167,'Cabricán','13'),
  (168,'Cajolá','13'),
  (169,'San Miguel Siguilá','13'),
  (170,'San Juan Ostuncalco','13'),
  (171,'San Mateo','13'),
  (172,'Concepción Chiquirichapa','13'),
  (173,'San Martín Sacatepéquez','13'),
  (174,'Almolonga','13'),
  (175,'Cantel','13'),
  (176,'Huitán','13'),
  (177,'Zunil','13'),
  (178,'Colomba Costa Cuca','13'),
  (179,'San Francisco La Unión','13'),
  (180,'El Palmar','13'),
  (181,'Coatepeque','13'),
  (182,'Génova','13'),
  (183,'Flores Costa Cuca','13'),
  (184,'La Esperanza','13'),
  (185,'Palestina de Los Altos','13'),
  (186,'Santa Cruz del Quiché','14'),
  (187,'Chiché','14'),
  (188,'Chinique','14'),
  (189,'Zacualpa','14'),
  (190,'Chajul','14'),
  (191,'Santo Tomás Chichicastenango','14'),
  (192,'Patzité','14'),
  (193,'San Antonio Ilotenango','14'),
  (194,'San Pedro Jocopilas','14'),
  (195,'Cunén','14'),
  (196,'San Juan Cotzal','14'),
  (197,'Santa María Joyabaj','14'),
  (198,'Santa María Nebaj','14'),
  (199,'San Andrés Sajcabajá','14'),
  (200,'Uspantán','14'),
  (201,'Sacapulas','14'),
  (202,'San Bartolomé Jocotenango','14'),
  (203,'Canillá','14'),
  (204,'Chicamán','14'),
  (205,'Ixcán','14'),
  (206,'Pachalum','14'),
  (207,'Retalhuleu','15'),
  (208,'San Sebastián','15'),
  (209,'Santa Cruz Muluá','15'),
  (210,'San Martín Zapotitlán','15'),
  (211,'San Felipe','15'),
  (212,'San Andrés Villa Seca','15'),
  (213,'Champerico','15'),
  (214,'Nuevo San Carlos','15'),
  (215,'El Asintal','15'),
  (216,'Antigua Guatemala','16'),
  (217,'Jocotenango','16'),
  (218,'Pastores','16'),
  (219,'Sumpango','16'),
  (220,'Santo Domingo Xenacoj','16'),
  (221,'Santiago Sacatepéquez','16'),
  (222,'San Bartolomé Milpas Altas','16'),
  (223,'San Lucas Sacatepéquez','16'),
  (224,'Santa Lucía Milpas Altas','16'),
  (225,'Magdalena Milpas Altas','16'),
  (226,'Santa María de Jesús','16'),
  (227,'Ciudad Vieja','16'),
  (228,'San Miguel Dueñas','16'),
  (229,'San Juan Alotenango','16'),
  (230,'San Antonio Aguas Calientes','16'),
  (231,'Santa Catarina Barahona','16'),
  (232,'San Marcos','17'),
  (233,'Ayutla','17'),
  (234,'Catarina','17'),
  (235,'Comitancillo','17'),
  (236,'Concepción Tutuapa','17'),
  (237,'El Quetzal','17'),
  (238,'El Rodeo','17'),
  (239,'El Tumblador','17'),
  (240,'Ixchiguán','17'),
  (241,'La Reforma','17'),
  (242,'Malacatán','17'),
  (243,'Nuevo Progreso','17'),
  (244,'Ocós','17'),
  (245,'Pajapita','17'),
  (246,'Esquipulas Palo Gordo','17'),
  (247,'San Antonio Sacatepéquez','17'),
  (248,'San Cristóbal Cucho','17'),
  (249,'San José Ojetenam','17'),
  (250,'San Lorenzo','17'),
  (251,'San Miguel Ixtahuacán','17'),
  (252,'San Pablo','17'),
  (253,'San Pedro Sacatepéquez','17'),
  (254,'San Rafael Pie de la Cuesta','17'),
  (255,'Sibinal','17'),
  (256,'Sipacapa','17'),
  (257,'Tacaná','17'),
  (258,'Tajumulco','17'),
  (259,'Tejutla','17'),
  (260,'Río Blanco','17'),
  (261,'La Blanca','17'),
  (262,'Cuilapa','18'),
  (263,'Casillas Santa Rosa','18'),
  (264,'Chiquimulilla','18'),
  (265,'Guazacapán','18'),
  (266,'Nueva Santa Rosa','18'),
  (267,'Oratorio','18'),
  (268,'Pueblo Nuevo Viñas','18'),
  (269,'San Juan Tecuaco','18'),
  (270,'San Rafael Las Flores','18'),
  (271,'Santa Cruz Naranjo','18'),
  (272,'Santa María Ixhuatán','18'),
  (273,'Santa Rosa de Lima','18'),
  (274,'Taxisco','18'),
  (275,'Barberena','18'),
  (276,'Sololá','19'),
  (277,'Concepción','19'),
  (278,'Nahualá','19'),
  (279,'Panajachel','19'),
  (280,'San Andrés Semetabaj','19'),
  (281,'San Antonio Palopó','19'),
  (282,'San José Chacayá','19'),
  (283,'San Juan La Laguna','19'),
  (284,'San Lucas Tolimán','19'),
  (285,'San Marcos La Laguna','19'),
  (286,'San Pablo La Laguna','19'),
  (287,'San Pedro La Laguna','19'),
  (288,'Santa Catarina Ixtahuacán','19'),
  (289,'Santa Catarina Palopó','19'),
  (290,'Santa Clara La Laguna','19'),
  (291,'Santa Cruz La Laguna','19'),
  (292,'Santa Lucía Utatlán','19'),
  (293,'Santa María Visitación','19'),
  (294,'Santiago Atitlán','19'),
  (295,'Mazatenango','20'),
  (296,'Cuyotenango','20'),
  (297,'San Francisco Zapotitlán','20'),
  (298,'San Bernardino','20'),
  (299,'San José El Ídolo','20'),
  (300,'Santo Domingo Suchitépequez','20'),
  (301,'San Lorenzo','20'),
  (302,'Samayac','20'),
  (303,'San Pablo Jocopilas','20'),
  (304,'San Antonio Suchitépequez','20'),
  (305,'San Miguel Panán','20'),
  (306,'San Gabriel','20'),
  (307,'Chicacao','20'),
  (308,'Patulul','20'),
  (309,'Santa Bárbara','20'),
  (310,'San Juan Bautista','20'),
  (311,'Santo Tomás La Unión','20'),
  (312,'Zunilito','20'),
  (313,'Pueblo Nuevo','20'),
  (314,'Río Bravo','20'),
  (315,'Totonicapán','21'),
  (316,'San Cristóbal Totonicapán','21'),
  (317,'San Francisco El Alto','21'),
  (318,'San Andrés Xecul','21'),
  (319,'Momostenango','21'),
  (320,'Santa María Chiquimula','21'),
  (321,'Santa Lucía La Reforma','21'),
  (322,'San Bartolo','21'),
  (323,'Cabañas','22'),
  (324,'Estanzuela','22'),
  (325,'Gualán','22'),
  (326,'Huité','22'),
  (327,'La Unión','22'),
  (328,'Río Hondo','22'),
  (329,'San Jorge','22'),
  (330,'San Diego','22'),
  (331,'Teculután','22'),
  (332,'Usumatlán','22'),
  (333,'Zacapa','22')
;

-- ===============================================
-- Tabla Direccion
-- ===============================================

CREATE TABLE  sae.direccion(
                             id_direccion SERIAL PRIMARY KEY,
                             id_departamento INT, --FK (sae.departamento)
                             id_municipio INT, --FK (sae.municipio)
                             zona INT,
                             calle VARCHAR,
                             avenida VARCHAR,
                             numero_casa VARCHAR,
                             direccion_exacta VARCHAR,
                             referencia VARCHAR,
                             id_tipo_direccion INT, --FK (sae.item)
                             FOREIGN KEY (id_tipo_direccion) REFERENCES sae.item(id_item)
);


-- ===============================================
-- Tabla Persona
-- ===============================================
CREATE TABLE sae.persona(
                          id_persona SERIAL PRIMARY KEY,
                          primer_nombre VARCHAR,
                          segundo_nombre VARCHAR,
                          tercer_nombre VARCHAR,
                          primer_apellido VARCHAR,
                          segundo_apellido VARCHAR,
                          apellido_casada VARCHAR,
                          cui NUMERIC,
                          pasaporte NUMERIC,
                          telefono_celular NUMERIC,
                          fecha_nacimiento DATE,
                          id_genero INT, --FK (sae.item)
                          id_nacionalidad INT, --FK (sae.item)
                          edad INT,
                          id_direccion JSONB,
                          caracteristicas_fisicas VARCHAR,
                          vestimenta VARCHAR,
                          organizacion_criminal VARCHAR,
                          movilizacion VARCHAR,
                          FOREIGN KEY (id_genero) REFERENCES sae.item(id_item),
                          FOREIGN KEY (id_nacionalidad) REFERENCES sae.item(id_item)
);


-- ===============================================
-- Tabla Arma
-- ===============================================

CREATE TABLE sae.arma(
                       id_arma SERIAL PRIMARY KEY,
                       id_tipo_arma INT, --FK (sae.item)
                       id_marca_arma INT, --FK (sae.item)
                       modelo_arma VARCHAR,
                       id_pais_fabricante INT, --FK (sae.item)
                       registro VARCHAR UNIQUE,
                       licencia VARCHAR,
                       tenencia VARCHAR,
                       id_calibre INT, --FK (sae.item)
                       cantidad_tolvas INT,
                       cantidad_municion INT,
                       id_propietario VARCHAR,
                       id_estatus_arma INT, --FK (sae.item)
                       FOREIGN KEY (id_tipo_arma) REFERENCES sae.item(id_item),
                       FOREIGN KEY (id_marca_arma) REFERENCES sae.item(id_item),
                       FOREIGN KEY (id_pais_fabricante) REFERENCES sae.item(id_item),
                       FOREIGN KEY (id_calibre) REFERENCES sae.item(id_item),
                       FOREIGN KEY (id_estatus_arma) REFERENCES sae.item(id_item)
);

-- ===============================================
-- Tabla Propietario
-- ===============================================

CREATE TABLE sae.propietario(
                              id_propietario SERIAL PRIMARY KEY,
                              nombre_propietario VARCHAR,
                              id_tipo_propietario INT, --FK (sae.item)
                              FOREIGN KEY (id_tipo_propietario) REFERENCES sae.item(id_item)
);

-- ===============================================
-- Tabla Hecho
-- ===============================================


CREATE TABLE sae.hecho(
                        id_hecho SERIAL PRIMARY KEY,
  -- numero_diligencia VARCHAR, --Se fue para la tabla denuncia
                        id_tipo_hecho INT, --FK (sae.item)
                        fecha_hecho DATE,
                        hora_hecho TIME,
                        narracion VARCHAR,
                        id_demarcacion INT, --FK (sae.item)
                        id_direccion INT, --FK (sae.direccion)
                        FOREIGN KEY (id_tipo_hecho) REFERENCES sae.item(id_item),
                        FOREIGN KEY (id_demarcacion) REFERENCES sae.item(id_item),
                        FOREIGN KEY (id_direccion) REFERENCES sae.direccion(id_direccion)
);

-- ===============================================
-- Tabla Denuncia
-- ===============================================


CREATE TABLE sae.denuncia(
                           id_denuncia SERIAL PRIMARY KEY UNIQUE NOT NULL,
                           numero_documento VARCHAR,
                           id_tipo_documento INT, --FK (sae.item)
                           id_armas JSONB,
                           id_tipo_denuncia INT, --FK (sae.item)
                           id_hecho INT, --FK (sae.hecho)
                           FOREIGN KEY (id_tipo_documento) REFERENCES sae.item(id_item),
                           FOREIGN KEY (id_tipo_denuncia) REFERENCES sae.item(id_item),
                           FOREIGN KEY (id_hecho) REFERENCES sae.hecho(id_hecho) ON DELETE CASCADE --Aquinosesifunciona
);

-- ===============================================
-- Tabla Persona_Denuncia
-- ===============================================

CREATE TABLE sae.persona_denuncia(
                                   id_registro SERIAL PRIMARY KEY UNIQUE NOT NULL,
                                   id_persona INT, --FK (sae.persona)
                                   id_denuncia INT, --FK (sae.denuncia)
                                   id_tipo_persona INT, --FK (sae.item)
                                   FOREIGN KEY (id_persona) REFERENCES sae.persona(id_persona),
                                   FOREIGN KEY (id_denuncia) REFERENCES sae.denuncia(id_denuncia) ON DELETE CASCADE,
                                   FOREIGN KEY (id_tipo_persona) REFERENCES sae.item(id_item)
);

-- ===============================================
-- Tabla arma_recuperada
-- ===============================================
CREATE TABLE sae.arma_recuperada(
                                  id_recuperacion SERIAL PRIMARY KEY,
                                  id_arma INT,--FK (sae.arma)
                                  numero_documento VARCHAR,
                                  id_tipo_documento INT, --FK (sae.item)
                                  id_hecho INT, --FK (sae.hecho)
                                  id_personas JSONB, --FK (sae.persona)
                                  id_tipo_persona INT, --FK (sae.item)
                                  dependencia_policial VARCHAR, --FK (sae.item)
                                  FOREIGN KEY (id_arma) REFERENCES sae.arma(id_arma),
                                  FOREIGN KEY (id_tipo_documento) REFERENCES sae.item(id_item),
                                  FOREIGN KEY (id_hecho) REFERENCES sae.hecho(id_hecho),
                                  FOREIGN KEY (id_tipo_persona) REFERENCES sae.item(id_item)
);

-- ===============================================
-- Tabla registro_procedimiento
-- ===============================================

CREATE TABLE sae.registro_procedimiento_arma(
                                              id_procedimiento SERIAL PRIMARY KEY,
                                              id_tipo_procedimiento INT, --FK (sae.item)
                                              id_arma INT, --FK (sae.arma)
                                              id_denuncia INT,
                                              id_autor INT, --FK public.users.
                                              numero_documento VARCHAR,
                                              id_tipo_documento INT, --FK (sae.item)
                                              descripcion VARCHAR,
                                              id_estatus_arma_registrado INT, --FK (sae.item)
                                              fecha_creacion timestamp,
                                              fecha_actualizacion timestamp,
                                              FOREIGN KEY (id_tipo_procedimiento) REFERENCES sae.item(id_item), 
                                              FOREIGN KEY (id_arma) REFERENCES sae.arma(id_arma),
                                              FOREIGN KEY (id_denuncia) REFERENCES sae.denuncia(id_denuncia) ON DELETE CASCADE, --Veremos como funciona
                                              FOREIGN KEY (id_autor) REFERENCES public.users(id_user),
                                              FOREIGN KEY (id_tipo_documento) REFERENCES sae.item(id_item),
                                              FOREIGN KEY (id_estatus_arma_registrado) REFERENCES sae.item(id_item)
);

-- ===============================================
-- Tabla Estado Arma Denuncia
-- ===============================================
CREATE TABLE sae.estatus_arma_denuncia(
                                        id_registro SERIAL PRIMARY KEY,
                                        id_estatus_denuncia INT, --FK (sae.item)
                                        id_armas JSONB, --FK (sae.arma)
                                        id_denuncia INT, --FK (sae.denuncia)
                                        FOREIGN KEY (id_estatus_denuncia) REFERENCES sae.item(id_item),
                                        -- FOREIGN KEY (id_armas) REFERENCES sae.arma(id_arma),
                                        FOREIGN KEY (id_denuncia) REFERENCES sae.denuncia(id_denuncia) ON DELETE CASCADE
);

-- ===============================================
-- Tabla Archivo
-- ===============================================

CREATE TABLE sae.archivo(
                          id_archivo SERIAL PRIMARY KEY,
                          id_denuncia INT,
  -- id_incautacion INT, -- Pendiente
  -- id_recuperacion INT, -- Pendiente
                          nombre varchar,
                          nombre_hash varchar,
                          mime varchar,
                          FOREIGN KEY(id_denuncia) REFERENCES sae.denuncia(id_denuncia) ON DELETE CASCADE
);
