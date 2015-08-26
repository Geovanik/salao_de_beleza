--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: cliente; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cliente (
    cpf character varying(15) NOT NULL,
    nome character varying(20) NOT NULL,
    email character varying(50) NOT NULL,
    endereco character varying(30) NOT NULL,
    telefone character varying(15) NOT NULL,
    dtnasc date NOT NULL
);


ALTER TABLE public.cliente OWNER TO postgres;

--
-- Name: funcionario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE funcionario (
    cpf character varying(15) NOT NULL,
    cargo character varying(15) NOT NULL,
    nome character varying(20) NOT NULL,
    login character varying(15) NOT NULL,
    senha character varying(128) NOT NULL,
    fone character varying(15) NOT NULL
);


ALTER TABLE public.funcionario OWNER TO postgres;

--
-- Name: horario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE horario (
    dt date NOT NULL,
    hora integer NOT NULL,
    caixa character varying(15) NOT NULL,
    cliente character varying(15) NOT NULL,
    func character varying(15) NOT NULL,
    servico integer NOT NULL,
    situacao integer NOT NULL
);


ALTER TABLE public.horario OWNER TO postgres;

--
-- Name: servico_cod_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE servico_cod_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.servico_cod_seq1 OWNER TO postgres;

--
-- Name: servico; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE servico (
    cod integer DEFAULT nextval('servico_cod_seq1'::regclass) NOT NULL,
    descr character varying(100) NOT NULL,
    valor real NOT NULL
);


ALTER TABLE public.servico OWNER TO postgres;

--
-- Name: pk_cpf; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY funcionario
    ADD CONSTRAINT pk_cpf PRIMARY KEY (cpf);


--
-- Name: pk_cpfc; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cliente
    ADD CONSTRAINT pk_cpfc PRIMARY KEY (cpf);


--
-- Name: pk_horario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT pk_horario PRIMARY KEY (dt, hora, cliente, func);


--
-- Name: pk_servico; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servico
    ADD CONSTRAINT pk_servico PRIMARY KEY (cod);


--
-- Name: fk_caihor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT fk_caihor FOREIGN KEY (caixa) REFERENCES funcionario(cpf);


--
-- Name: fk_clihor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT fk_clihor FOREIGN KEY (cliente) REFERENCES cliente(cpf);


--
-- Name: fk_funhor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT fk_funhor FOREIGN KEY (func) REFERENCES funcionario(cpf);


--
-- Name: fk_serhor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT fk_serhor FOREIGN KEY (servico) REFERENCES servico(cod);


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

