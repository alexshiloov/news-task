CREATE TABLE news
(
    id int AUTO_INCREMENT not null,
    title varchar(256) NOT NULL,
    description TEXT(1024),
    short_description varchar(256),
    created_at DATETIME,
    updated_at DATETIME,
    published_at DATETIME,
    is_active BOOLEAN NOT NULL DEFAULT FALSE,
    is_hide BOOLEAN NOT NULL DEFAULT FALSE,
    hits int NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

CREATE TABLE sitemap
(
    id int AUTO_INCREMENT not NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    xml MEDIUMTEXT not NULL,
    PRIMARY KEY (id)
)
