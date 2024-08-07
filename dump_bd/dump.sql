PGDMP         -                {           manga    15.3    15.3 K    X           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            Y           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            Z           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            [           1262    16399    manga    DATABASE     y   CREATE DATABASE manga WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'French_Belgium.1252';
    DROP DATABASE manga;
                mirko    false            �            1255    16711    addville(text, text)    FUNCTION     �  CREATE FUNCTION public.addville(nomville text, nompays text) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    v_idville INTEGER;
    v_idpays INTEGER;
BEGIN
    SELECT id_ville INTO v_idville FROM ville WHERE nom_ville = nomville;
    IF not found THEN
        SELECT id_pays INTO v_idpays FROM pays WHERE nom_pays = nompays;
        IF not found THEN
            BEGIN
                INSERT INTO pays(nom_pays) VALUES (nompays);
                EXCEPTION WHEN unique_violation THEN
                    RAISE NOTICE 'Un autre processus a inséré la même valeur';
            END;
            SELECT id_pays INTO v_idpays FROM pays WHERE nom_pays = nompays;
			INSERT INTO ville(nom_ville,id_pays) VALUES (nomville,v_idpays);
			RETURN 1;
        ELSE
            INSERT INTO ville(nom_ville,id_pays) VALUES (nomville,v_idpays);
            RETURN 1;
        END IF;
    ELSE
        RETURN 0;
    END IF;
    
    -- Add a return statement for the case where a new row is not inserted
    RETURN 0;
END;
$$;
 <   DROP FUNCTION public.addville(nomville text, nompays text);
       public          postgres    false            �            1255    16741    verifier_connexion(text, text)    FUNCTION     �  CREATE FUNCTION public.verifier_connexion(text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
	declare f_login alias for $1;
	declare f_password alias for $2;
	declare id integer;
	declare retour integer;
begin
	select into id id_admin from admin where login=f_login and password=f_password;
	if not found
	then
	  retour=0;
	else
	  retour=1;
	end if;
	return retour;
end;
$_$;
 5   DROP FUNCTION public.verifier_connexion(text, text);
       public          postgres    false            �            1259    16614    admin    TABLE     i   CREATE TABLE public.admin (
    id_admin integer NOT NULL,
    login text NOT NULL,
    password text
);
    DROP TABLE public.admin;
       public         heap    mirko    false            �            1259    16622 	   categorie    TABLE     f   CREATE TABLE public.categorie (
    id_categorie integer NOT NULL,
    nom_categorie text NOT NULL
);
    DROP TABLE public.categorie;
       public         heap    postgres    false            �            1259    16621    categorie_id_categorie_seq    SEQUENCE     �   CREATE SEQUENCE public.categorie_id_categorie_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.categorie_id_categorie_seq;
       public          postgres    false    216            \           0    0    categorie_id_categorie_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.categorie_id_categorie_seq OWNED BY public.categorie.id_categorie;
          public          postgres    false    215            �            1259    16723    client_id_client_seq    SEQUENCE     }   CREATE SEQUENCE public.client_id_client_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.client_id_client_seq;
       public          postgres    false            �            1259    16670    client    TABLE     �   CREATE TABLE public.client (
    nom_client text NOT NULL,
    password text NOT NULL,
    email_client text NOT NULL,
    id_ville integer NOT NULL,
    id_client integer DEFAULT nextval('public.client_id_client_seq'::regclass) NOT NULL
);
    DROP TABLE public.client;
       public         heap    mirko    false    228            �            1259    16660    commande    TABLE     �   CREATE TABLE public.commande (
    id_commande integer NOT NULL,
    date_commande date,
    prix_commande numeric(15,2),
    id_client integer
);
    DROP TABLE public.commande;
       public         heap    postgres    false            �            1259    16650    detail    TABLE     �   CREATE TABLE public.detail (
    id_detail integer NOT NULL,
    quantite integer NOT NULL,
    id_commande integer NOT NULL,
    id_manga integer NOT NULL
);
    DROP TABLE public.detail;
       public         heap    postgres    false            �            1259    16633    manga    TABLE     �   CREATE TABLE public.manga (
    id_manga integer NOT NULL,
    nom_manga text NOT NULL,
    description text NOT NULL,
    prix numeric(15,2) NOT NULL,
    id_categorie integer NOT NULL,
    image text
);
    DROP TABLE public.manga;
       public         heap    postgres    false            �            1259    16742    commande_full    VIEW     W  CREATE VIEW public.commande_full AS
 SELECT c.id_commande,
    c.id_client,
    d.quantite,
    p.id_manga,
    p.prix,
    (p.prix * (d.quantite)::numeric) AS tot_row
   FROM ((public.detail d
     JOIN public.commande c ON ((d.id_commande = c.id_commande)))
     JOIN public.manga p ON ((d.id_manga = p.id_manga)))
  ORDER BY c.id_commande;
     DROP VIEW public.commande_full;
       public          postgres    false    218    218    220    220    220    221    221            �            1259    16759    commande_id_commande_seq    SEQUENCE     �   CREATE SEQUENCE public.commande_id_commande_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.commande_id_commande_seq;
       public          postgres    false    221            ]           0    0    commande_id_commande_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.commande_id_commande_seq OWNED BY public.commande.id_commande;
          public          postgres    false    230            �            1259    16760    detail_id_detail_seq    SEQUENCE     �   CREATE SEQUENCE public.detail_id_detail_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 +   DROP SEQUENCE public.detail_id_detail_seq;
       public          postgres    false    220            ^           0    0    detail_id_detail_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.detail_id_detail_seq OWNED BY public.detail.id_detail;
          public          postgres    false    231            �            1259    16648    manga_id_categorie_seq    SEQUENCE     �   CREATE SEQUENCE public.manga_id_categorie_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.manga_id_categorie_seq;
       public          postgres    false    218            _           0    0    manga_id_categorie_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.manga_id_categorie_seq OWNED BY public.manga.id_categorie;
          public          postgres    false    219            �            1259    16632    manga_id_manga_seq    SEQUENCE     �   CREATE SEQUENCE public.manga_id_manga_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.manga_id_manga_seq;
       public          postgres    false    218            `           0    0    manga_id_manga_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.manga_id_manga_seq OWNED BY public.manga.id_manga;
          public          postgres    false    217            �            1259    16686    pays    TABLE     W   CREATE TABLE public.pays (
    id_pays integer NOT NULL,
    nom_pays text NOT NULL
);
    DROP TABLE public.pays;
       public         heap    mirko    false            �            1259    16722    pays_id_pays_seq    SEQUENCE     �   CREATE SEQUENCE public.pays_id_pays_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 '   DROP SEQUENCE public.pays_id_pays_seq;
       public          mirko    false    224            a           0    0    pays_id_pays_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.pays_id_pays_seq OWNED BY public.pays.id_pays;
          public          mirko    false    227            �            1259    16679    ville    TABLE     x   CREATE TABLE public.ville (
    id_ville integer NOT NULL,
    nom_ville text NOT NULL,
    id_pays integer NOT NULL
);
    DROP TABLE public.ville;
       public         heap    mirko    false            �            1259    16720    ville_id_pays_seq    SEQUENCE     �   CREATE SEQUENCE public.ville_id_pays_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.ville_id_pays_seq;
       public          mirko    false    223            b           0    0    ville_id_pays_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.ville_id_pays_seq OWNED BY public.ville.id_pays;
          public          mirko    false    225            �            1259    16721    ville_id_ville_seq    SEQUENCE     �   CREATE SEQUENCE public.ville_id_ville_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 )   DROP SEQUENCE public.ville_id_ville_seq;
       public          mirko    false    223            c           0    0    ville_id_ville_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.ville_id_ville_seq OWNED BY public.ville.id_ville;
          public          mirko    false    226            �           2604    16625    categorie id_categorie    DEFAULT     �   ALTER TABLE ONLY public.categorie ALTER COLUMN id_categorie SET DEFAULT nextval('public.categorie_id_categorie_seq'::regclass);
 E   ALTER TABLE public.categorie ALTER COLUMN id_categorie DROP DEFAULT;
       public          postgres    false    216    215    216            �           2604    16761    commande id_commande    DEFAULT     |   ALTER TABLE ONLY public.commande ALTER COLUMN id_commande SET DEFAULT nextval('public.commande_id_commande_seq'::regclass);
 C   ALTER TABLE public.commande ALTER COLUMN id_commande DROP DEFAULT;
       public          postgres    false    230    221            �           2604    16762    detail id_detail    DEFAULT     t   ALTER TABLE ONLY public.detail ALTER COLUMN id_detail SET DEFAULT nextval('public.detail_id_detail_seq'::regclass);
 ?   ALTER TABLE public.detail ALTER COLUMN id_detail DROP DEFAULT;
       public          postgres    false    231    220            �           2604    16636    manga id_manga    DEFAULT     p   ALTER TABLE ONLY public.manga ALTER COLUMN id_manga SET DEFAULT nextval('public.manga_id_manga_seq'::regclass);
 =   ALTER TABLE public.manga ALTER COLUMN id_manga DROP DEFAULT;
       public          postgres    false    217    218    218            �           2604    16649    manga id_categorie    DEFAULT     x   ALTER TABLE ONLY public.manga ALTER COLUMN id_categorie SET DEFAULT nextval('public.manga_id_categorie_seq'::regclass);
 A   ALTER TABLE public.manga ALTER COLUMN id_categorie DROP DEFAULT;
       public          postgres    false    219    218            �           2604    16739    pays id_pays    DEFAULT     l   ALTER TABLE ONLY public.pays ALTER COLUMN id_pays SET DEFAULT nextval('public.pays_id_pays_seq'::regclass);
 ;   ALTER TABLE public.pays ALTER COLUMN id_pays DROP DEFAULT;
       public          mirko    false    227    224            �           2604    16740    ville id_ville    DEFAULT     p   ALTER TABLE ONLY public.ville ALTER COLUMN id_ville SET DEFAULT nextval('public.ville_id_ville_seq'::regclass);
 =   ALTER TABLE public.ville ALTER COLUMN id_ville DROP DEFAULT;
       public          mirko    false    226    223            E          0    16614    admin 
   TABLE DATA           :   COPY public.admin (id_admin, login, password) FROM stdin;
    public          mirko    false    214   �X       G          0    16622 	   categorie 
   TABLE DATA           @   COPY public.categorie (id_categorie, nom_categorie) FROM stdin;
    public          postgres    false    216   �X       M          0    16670    client 
   TABLE DATA           Y   COPY public.client (nom_client, password, email_client, id_ville, id_client) FROM stdin;
    public          mirko    false    222   �X       L          0    16660    commande 
   TABLE DATA           X   COPY public.commande (id_commande, date_commande, prix_commande, id_client) FROM stdin;
    public          postgres    false    221   eY       K          0    16650    detail 
   TABLE DATA           L   COPY public.detail (id_detail, quantite, id_commande, id_manga) FROM stdin;
    public          postgres    false    220   �Y       I          0    16633    manga 
   TABLE DATA           \   COPY public.manga (id_manga, nom_manga, description, prix, id_categorie, image) FROM stdin;
    public          postgres    false    218   �Y       O          0    16686    pays 
   TABLE DATA           1   COPY public.pays (id_pays, nom_pays) FROM stdin;
    public          mirko    false    224   �[       N          0    16679    ville 
   TABLE DATA           =   COPY public.ville (id_ville, nom_ville, id_pays) FROM stdin;
    public          mirko    false    223   �[       d           0    0    categorie_id_categorie_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.categorie_id_categorie_seq', 4, true);
          public          postgres    false    215            e           0    0    client_id_client_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.client_id_client_seq', 6, true);
          public          postgres    false    228            f           0    0    commande_id_commande_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.commande_id_commande_seq', 38, true);
          public          postgres    false    230            g           0    0    detail_id_detail_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.detail_id_detail_seq', 29, true);
          public          postgres    false    231            h           0    0    manga_id_categorie_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.manga_id_categorie_seq', 1, false);
          public          postgres    false    219            i           0    0    manga_id_manga_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.manga_id_manga_seq', 46, true);
          public          postgres    false    217            j           0    0    pays_id_pays_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.pays_id_pays_seq', 3, true);
          public          mirko    false    227            k           0    0    ville_id_pays_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.ville_id_pays_seq', 1, false);
          public          mirko    false    225            l           0    0    ville_id_ville_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.ville_id_ville_seq', 4, true);
          public          mirko    false    226            �           2606    16620    admin admin_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.admin
    ADD CONSTRAINT admin_pkey PRIMARY KEY (id_admin);
 :   ALTER TABLE ONLY public.admin DROP CONSTRAINT admin_pkey;
       public            mirko    false    214            �           2606    16631 %   categorie categorie_nom_categorie_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.categorie
    ADD CONSTRAINT categorie_nom_categorie_key UNIQUE (nom_categorie);
 O   ALTER TABLE ONLY public.categorie DROP CONSTRAINT categorie_nom_categorie_key;
       public            postgres    false    216            �           2606    16629    categorie categorie_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.categorie
    ADD CONSTRAINT categorie_pkey PRIMARY KEY (id_categorie);
 B   ALTER TABLE ONLY public.categorie DROP CONSTRAINT categorie_pkey;
       public            postgres    false    216            �           2606    16678 !   client client_email_client_unique 
   CONSTRAINT     d   ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_email_client_unique UNIQUE (email_client);
 K   ALTER TABLE ONLY public.client DROP CONSTRAINT client_email_client_unique;
       public            mirko    false    222            �           2606    16733    client client_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id_client);
 <   ALTER TABLE ONLY public.client DROP CONSTRAINT client_pkey;
       public            mirko    false    222            �           2606    16664    commande commande_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_pkey PRIMARY KEY (id_commande);
 @   ALTER TABLE ONLY public.commande DROP CONSTRAINT commande_pkey;
       public            postgres    false    221            �           2606    16654    detail detail_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.detail
    ADD CONSTRAINT detail_pkey PRIMARY KEY (id_detail);
 <   ALTER TABLE ONLY public.detail DROP CONSTRAINT detail_pkey;
       public            postgres    false    220            �           2606    16640    manga manga_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.manga
    ADD CONSTRAINT manga_pkey PRIMARY KEY (id_manga);
 :   ALTER TABLE ONLY public.manga DROP CONSTRAINT manga_pkey;
       public            postgres    false    218            �           2606    16642    manga nom_manga_unique 
   CONSTRAINT     V   ALTER TABLE ONLY public.manga
    ADD CONSTRAINT nom_manga_unique UNIQUE (nom_manga);
 @   ALTER TABLE ONLY public.manga DROP CONSTRAINT nom_manga_unique;
       public            postgres    false    218            �           2606    16694    pays pays_nom_pays_unique 
   CONSTRAINT     X   ALTER TABLE ONLY public.pays
    ADD CONSTRAINT pays_nom_pays_unique UNIQUE (nom_pays);
 C   ALTER TABLE ONLY public.pays DROP CONSTRAINT pays_nom_pays_unique;
       public            mirko    false    224            �           2606    16692    pays pays_pk 
   CONSTRAINT     O   ALTER TABLE ONLY public.pays
    ADD CONSTRAINT pays_pk PRIMARY KEY (id_pays);
 6   ALTER TABLE ONLY public.pays DROP CONSTRAINT pays_pk;
       public            mirko    false    224            �           2606    16685    ville ville_pk 
   CONSTRAINT     R   ALTER TABLE ONLY public.ville
    ADD CONSTRAINT ville_pk PRIMARY KEY (id_ville);
 8   ALTER TABLE ONLY public.ville DROP CONSTRAINT ville_pk;
       public            mirko    false    223            �           1259    16710    fki_commande_id_client_fk    INDEX     S   CREATE INDEX fki_commande_id_client_fk ON public.commande USING btree (id_client);
 -   DROP INDEX public.fki_commande_id_client_fk;
       public            postgres    false    221            �           2606    16700    client client_id_ville_fk    FK CONSTRAINT        ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_id_ville_fk FOREIGN KEY (id_ville) REFERENCES public.ville(id_ville);
 C   ALTER TABLE ONLY public.client DROP CONSTRAINT client_id_ville_fk;
       public          mirko    false    223    3243    222            �           2606    16734    commande commande_id_client_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_id_client_fk FOREIGN KEY (id_client) REFERENCES public.client(id_client);
 H   ALTER TABLE ONLY public.commande DROP CONSTRAINT commande_id_client_fk;
       public          postgres    false    3241    221    222            �           2606    16665    detail detail_id_commande_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail
    ADD CONSTRAINT detail_id_commande_fkey FOREIGN KEY (id_commande) REFERENCES public.commande(id_commande);
 H   ALTER TABLE ONLY public.detail DROP CONSTRAINT detail_id_commande_fkey;
       public          postgres    false    220    3236    221            �           2606    16655    detail detail_id_manga_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail
    ADD CONSTRAINT detail_id_manga_fkey FOREIGN KEY (id_manga) REFERENCES public.manga(id_manga);
 E   ALTER TABLE ONLY public.detail DROP CONSTRAINT detail_id_manga_fkey;
       public          postgres    false    220    3230    218            �           2606    16643    manga manga_id_categorie_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.manga
    ADD CONSTRAINT manga_id_categorie_fkey FOREIGN KEY (id_categorie) REFERENCES public.categorie(id_categorie);
 G   ALTER TABLE ONLY public.manga DROP CONSTRAINT manga_id_categorie_fkey;
       public          postgres    false    3228    216    218            �           2606    16695    ville ville_id_pays_fk    FK CONSTRAINT     y   ALTER TABLE ONLY public.ville
    ADD CONSTRAINT ville_id_pays_fk FOREIGN KEY (id_pays) REFERENCES public.pays(id_pays);
 @   ALTER TABLE ONLY public.ville DROP CONSTRAINT ville_id_pays_fk;
       public          mirko    false    3247    224    223            E      x�3�LL��̃�\1z\\\ 8Z      G   #   x�3��8ڛ���efe�s�p�f�Db���� �@
      M   X   x����)�N��M)��3�s3s���s9�8M�|3���9}]8�,=�����|����2cNS.����T�)>�E��(�&�f\1z\\\ �Q"-      L      x������ � �      K      x������ � �      I     x�MS�n�0��8(�$�c;iִ\4�R�h�.g�,1��*��O����w_�'�-4	$���~N�k���}?J�e��Z�ͯ�Uk��u�Ҕ��B=�������`=4Q{�����˶·c:�����?#]£f���{<��K]�^� }NƐ���H]m
d��ϭk��qv���f���P�x ������<�e����Zb��.r��rx9�4M���tG�eFQG��'��} h�Pt�z���V�0p��J�bT��r% ���Z} ��핺^���ڎSԍ��%n-�a��f��U_qB^�p�~P����q��l�T��P���9TkT�z�"�.��q6�|�"Q�F&�c��%�2u����<�����M4#B�+4�&[��i0�K���Ucck��MC&u.�l�����K�:�N[7��R�;�$�uMpo�lSY�>�>ʡ�N�"C�;�K��/��携��z	۝6:�M��?�"E0��9�	��
���0�a�(���2����f�#��f<-9      O   !   x�3�tJ�I�,,M�2�.�,.N����� ae�      N   /   x�3�t**�H��I-�4�2�tO�;��,�Ә˄���+F��� 
��     