--
-- PostgreSQL database dump
--

\restrict tsfk1hyBjFzK4gwVhnbHyB2GQ0qdNJKhagkURSi7oCwDvzNIDSXxiEXkswRfwsZ

-- Dumped from database version 18.0
-- Dumped by pg_dump version 18.0

-- Started on 2025-11-22 22:58:59

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 222 (class 1259 OID 16434)
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id integer NOT NULL,
    idpedidoparceiro character varying(255) NOT NULL,
    valorfrete numeric(10,2) DEFAULT 0,
    formapagamento integer NOT NULL,
    sku integer NOT NULL,
    valorunitario numeric(10,2) NOT NULL,
    quantidade integer NOT NULL,
    status integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16433)
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedidos_id_seq OWNER TO postgres;

--
-- TOC entry 5031 (class 0 OID 0)
-- Dependencies: 221
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- TOC entry 220 (class 1259 OID 16409)
-- Name: produtos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produtos (
    id integer NOT NULL,
    sku character varying(100),
    name character varying(255) NOT NULL,
    description text NOT NULL,
    status character varying(20) NOT NULL,
    price numeric(10,2) NOT NULL,
    promotional_price numeric(10,2) NOT NULL,
    cost numeric(10,2) NOT NULL,
    weight numeric(10,3) NOT NULL,
    width numeric(10,2) NOT NULL,
    height numeric(10,2) NOT NULL,
    length numeric(10,2) NOT NULL,
    brand character varying(255) NOT NULL,
    shortname character varying(255),
    wordkeys text,
    nbm character varying(50),
    model character varying(255),
    gender character varying(50),
    volumes integer,
    warrantytime integer,
    category character varying(255),
    subcategory character varying(255),
    endcategory character varying(255),
    urlyoutube text,
    googledescription text,
    manufacturing character varying(50),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    quantidade integer,
    variations jsonb,
    CONSTRAINT produtos_manufacturing_check CHECK (((manufacturing)::text = ANY ((ARRAY['Nacional'::character varying, 'Importado'::character varying])::text[]))),
    CONSTRAINT produtos_status_check CHECK (((status)::text = ANY ((ARRAY['enabled'::character varying, 'disabled'::character varying])::text[])))
);


ALTER TABLE public.produtos OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16408)
-- Name: produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produtos_id_seq OWNER TO postgres;

--
-- TOC entry 5032 (class 0 OID 0)
-- Dependencies: 219
-- Name: produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produtos_id_seq OWNED BY public.produtos.id;


--
-- TOC entry 4864 (class 2604 OID 16437)
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- TOC entry 4861 (class 2604 OID 16412)
-- Name: produtos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos ALTER COLUMN id SET DEFAULT nextval('public.produtos_id_seq'::regclass);


--
-- TOC entry 5025 (class 0 OID 16434)
-- Dependencies: 222
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedidos (id, idpedidoparceiro, valorfrete, formapagamento, sku, valorunitario, quantidade, status, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5023 (class 0 OID 16409)
-- Dependencies: 220
-- Data for Name: produtos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produtos (id, sku, name, description, status, price, promotional_price, cost, weight, width, height, length, brand, shortname, wordkeys, nbm, model, gender, volumes, warrantytime, category, subcategory, endcategory, urlyoutube, googledescription, manufacturing, created_at, updated_at, quantidade, variations) FROM stdin;
\.


--
-- TOC entry 5033 (class 0 OID 0)
-- Dependencies: 221
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 2, true);


--
-- TOC entry 5034 (class 0 OID 0)
-- Dependencies: 219
-- Name: produtos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produtos_id_seq', 17, true);


--
-- TOC entry 4874 (class 2606 OID 16450)
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- TOC entry 4872 (class 2606 OID 16432)
-- Name: produtos produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id);


-- Completed on 2025-11-22 22:58:59

--
-- PostgreSQL database dump complete
--

\unrestrict tsfk1hyBjFzK4gwVhnbHyB2GQ0qdNJKhagkURSi7oCwDvzNIDSXxiEXkswRfwsZ

