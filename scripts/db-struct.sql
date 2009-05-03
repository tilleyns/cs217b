--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

DROP INDEX public.i_inet;
ALTER TABLE ONLY public.ipv4 DROP CONSTRAINT ipv4_pkey;
ALTER TABLE public.ipv4 ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE public.ipv4_id_seq;
DROP TABLE public.ipv4;
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: ipv4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ipv4 (
    id integer NOT NULL,
    on_date date,
    "RIR" text,
    country text,
    "IP" inet,
    is_adhoc boolean,
    "RIR_date" date,
    type text
);


ALTER TABLE public.ipv4 OWNER TO postgres;

--
-- Name: ipv4_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ipv4_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.ipv4_id_seq OWNER TO postgres;

--
-- Name: ipv4_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ipv4_id_seq OWNED BY ipv4.id;


--
-- Name: ipv4_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('ipv4_id_seq', 1, false);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ipv4 ALTER COLUMN id SET DEFAULT nextval('ipv4_id_seq'::regclass);


--
-- Data for Name: ipv4; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY ipv4 (id, on_date, "RIR", country, "IP", is_adhoc, "RIR_date", type) FROM stdin;
\.


--
-- Name: ipv4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ipv4
    ADD CONSTRAINT ipv4_pkey PRIMARY KEY (id);


--
-- Name: i_inet; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX i_inet ON ipv4 USING btree ("IP");


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

