DROP TABLE IF EXISTS users;

-- Tạo bảng users
create table users
(
    id             int auto_increment
        primary key,
    username       varchar(50)                                      not null,
    password       varchar(255)                                     not null,
    fullname       varchar(100)                                     null,
    email          varchar(100)                                     null,
    mobile         varchar(20)                                      null,
    address        text                                             null,
    image          varchar(255)                                     null,
    birthday       date                                             null,
    role           enum ('user', 'admin') default 'user'            null,
    otp            varchar(6)                                       null,
    otp_expires_at timestamp                                        null,
    created_at     timestamp              default CURRENT_TIMESTAMP null,
    updated_at     timestamp              default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    constraint username
        unique (username)
);

create index idx_otp
    on users (otp, otp_expires_at);

INSERT INTO `duan1-coda`.users (id, username, password, fullname, email, mobile, address, image, birthday, role, otp, otp_expires_at, created_at, updated_at) VALUES (1, 'admin', '$2y$10$nfDtsJM3MsJJESeANqBK7.i5l4ksvzH2VT19OrjDDUbKl7DiNiGL2', 'Administrator', 'ikuysle@outlook.com', null, null, null, null, 'admin', null, null, '2025-08-07 16:20:42', '2025-08-07 18:26:31');
INSERT INTO `duan1-coda`.users (id, username, password, fullname, email, mobile, address, image, birthday, role, otp, otp_expires_at, created_at, updated_at) VALUES (2, 'user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', 'user@example.com', null, null, null, null, 'user', null, null, '2025-08-07 16:20:42', '2025-08-07 16:20:42');

