--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5
-- Dumped by pg_dump version 12.0

-- Started on 2020-06-15 22:28:45

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

--
-- TOC entry 197 (class 1259 OID 16399)
-- Name: categorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre_categoria character varying(50) NOT NULL,
    descripcion_categoria character varying(250),
    imagen_categoria character varying(50) NOT NULL
);


ALTER TABLE public.categorias OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 16397)
-- Name: categorias_id_categoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categorias_id_categoria_seq OWNER TO postgres;

--
-- TOC entry 2879 (class 0 OID 0)
-- Dependencies: 196
-- Name: categorias_id_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;


--
-- TOC entry 203 (class 1259 OID 24679)
-- Name: clientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clientes (
    id_cliente integer NOT NULL,
    nombres_cliente character varying(50) NOT NULL,
    apellidos_cliente character varying(50) NOT NULL,
    dui_cliente character varying(10) NOT NULL,
    correo_cliente character varying(100) NOT NULL,
    telefono_cliente character varying(9) NOT NULL,
    nacimiento_cliente date NOT NULL,
    direccion_cliente character varying(200) NOT NULL,
    clave_cliente character varying(100) NOT NULL,
    estado_cliente boolean DEFAULT true NOT NULL
);


ALTER TABLE public.clientes OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 24677)
-- Name: clientes_id_cliente_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clientes_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.clientes_id_cliente_seq OWNER TO postgres;

--
-- TOC entry 2880 (class 0 OID 0)
-- Dependencies: 202
-- Name: clientes_id_cliente_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clientes_id_cliente_seq OWNED BY public.clientes.id_cliente;


--
-- TOC entry 207 (class 1259 OID 24709)
-- Name: detalle_pedido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pedido (
    id_detalle integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad_producto smallint NOT NULL,
    precio_producto numeric(5,2) NOT NULL,
    id_pedido integer NOT NULL
);


ALTER TABLE public.detalle_pedido OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 24707)
-- Name: detalle_pedidos_id_detalle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pedidos_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pedidos_id_detalle_seq OWNER TO postgres;

--
-- TOC entry 2881 (class 0 OID 0)
-- Dependencies: 206
-- Name: detalle_pedidos_id_detalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pedidos_id_detalle_seq OWNED BY public.detalle_pedido.id_detalle;


--
-- TOC entry 205 (class 1259 OID 24695)
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id_pedido integer NOT NULL,
    id_cliente integer NOT NULL,
    estado_pedido smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 24693)
-- Name: pedidos_id_pedido_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedidos_id_pedido_seq OWNER TO postgres;

--
-- TOC entry 2882 (class 0 OID 0)
-- Dependencies: 204
-- Name: pedidos_id_pedido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_pedido_seq OWNED BY public.pedidos.id_pedido;


--
-- TOC entry 199 (class 1259 OID 16408)
-- Name: productos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productos (
    id_producto integer NOT NULL,
    nombre_producto character varying(50) NOT NULL,
    descripcion_producto character varying(250) NOT NULL,
    precio_producto numeric(5,2) NOT NULL,
    imagen_producto character varying(50) NOT NULL,
    id_categoria integer NOT NULL,
    estado_producto boolean NOT NULL
);


ALTER TABLE public.productos OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 16406)
-- Name: productos_id_producto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productos_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.productos_id_producto_seq OWNER TO postgres;

--
-- TOC entry 2883 (class 0 OID 0)
-- Dependencies: 198
-- Name: productos_id_producto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productos_id_producto_seq OWNED BY public.productos.id_producto;


--
-- TOC entry 201 (class 1259 OID 16416)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    nombres_usuario character varying(50) NOT NULL,
    apellidos_usuario character varying(50) NOT NULL,
    correo_usuario character varying(100) NOT NULL,
    alias_usuario character varying(50) NOT NULL,
    clave_usuario character varying(100) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 16414)
-- Name: usuarios_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_usuario_seq OWNER TO postgres;

--
-- TOC entry 2884 (class 0 OID 0)
-- Dependencies: 200
-- Name: usuarios_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;


--
-- TOC entry 2716 (class 2604 OID 16402)
-- Name: categorias id_categoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);


--
-- TOC entry 2719 (class 2604 OID 24682)
-- Name: clientes id_cliente; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes ALTER COLUMN id_cliente SET DEFAULT nextval('public.clientes_id_cliente_seq'::regclass);


--
-- TOC entry 2723 (class 2604 OID 24712)
-- Name: detalle_pedido id_detalle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_pedidos_id_detalle_seq'::regclass);


--
-- TOC entry 2721 (class 2604 OID 24698)
-- Name: pedidos id_pedido; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedidos_id_pedido_seq'::regclass);


--
-- TOC entry 2717 (class 2604 OID 16411)
-- Name: productos id_producto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos ALTER COLUMN id_producto SET DEFAULT nextval('public.productos_id_producto_seq'::regclass);


--
-- TOC entry 2718 (class 2604 OID 16419)
-- Name: usuarios id_usuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);


--
-- TOC entry 2725 (class 2606 OID 16432)
-- Name: categorias categorias_nombre_categoria_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_nombre_categoria_key UNIQUE (nombre_categoria);


--
-- TOC entry 2727 (class 2606 OID 16404)
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);


--
-- TOC entry 2740 (class 2606 OID 24692)
-- Name: clientes clientes_correo_cliente_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_correo_cliente_key UNIQUE (correo_cliente);


--
-- TOC entry 2742 (class 2606 OID 24690)
-- Name: clientes clientes_dui_cliente_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_dui_cliente_key UNIQUE (dui_cliente);


--
-- TOC entry 2744 (class 2606 OID 24687)
-- Name: clientes clientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id_cliente);


--
-- TOC entry 2748 (class 2606 OID 24714)
-- Name: detalle_pedido detalle_pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detalle);


--
-- TOC entry 2746 (class 2606 OID 24700)
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedido);


--
-- TOC entry 2730 (class 2606 OID 16463)
-- Name: productos productos_nombre_producto_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_nombre_producto_key UNIQUE (nombre_producto);


--
-- TOC entry 2732 (class 2606 OID 16413)
-- Name: productos productos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id_producto);


--
-- TOC entry 2734 (class 2606 OID 16423)
-- Name: usuarios usuarios_alias_usuario_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_alias_usuario_key UNIQUE (alias_usuario);


--
-- TOC entry 2736 (class 2606 OID 16425)
-- Name: usuarios usuarios_correo_usuario_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_usuario_key UNIQUE (correo_usuario);


--
-- TOC entry 2738 (class 2606 OID 16421)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2728 (class 1259 OID 16405)
-- Name: nombre_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX nombre_index ON public.categorias USING btree (nombre_categoria);


--
-- TOC entry 2751 (class 2606 OID 24720)
-- Name: detalle_pedido detalle_pedido_id_pedido_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedidos(id_pedido) NOT VALID;


--
-- TOC entry 2752 (class 2606 OID 24715)
-- Name: detalle_pedido detalle_pedido_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);


--
-- TOC entry 2749 (class 2606 OID 16464)
-- Name: productos id_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_categoria FOREIGN KEY (id_categoria) REFERENCES public.categorias(id_categoria) NOT VALID;


--
-- TOC entry 2750 (class 2606 OID 24701)
-- Name: pedidos pedidos_id_cliente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);


-- Completed on 2020-06-15 22:28:46

--
-- PostgreSQL database dump complete
--

