-- Table: public.user

-- DROP TABLE IF EXISTS public."user";

CREATE TABLE IF NOT EXISTS public."user"
(
    id integer NOT NULL DEFAULT nextval('user_id_seq'::regclass),
    firstname character varying(50) COLLATE pg_catalog."default",
    lastname character varying(100) COLLATE pg_catalog."default",
    email character varying(320) COLLATE pg_catalog."default" NOT NULL,
    pwd character varying(255) COLLATE pg_catalog."default" NOT NULL,
    is_active boolean DEFAULT false,
    date_created date NOT NULL,
    date_updated date,
    CONSTRAINT user_pkey PRIMARY KEY (id)
    )

    TABLESPACE pg_default;

ALTER TABLE IF EXISTS public."user"
    OWNER to devuser;