CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` varchar(255) NOT NULL,
  `two_fa_code` varchar(255) NOT NULL,
  `two_factor_auth` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `createdat` datetime NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `loaners` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `loan_amount` varchar(255) NOT NULL,
  `interest` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `createdat` datetime,
  `is_approved` enum('No','Yes'),
  `approvedat` datetime,
  `receiver_id` varchar(255) NOT NULL,
  `is_terms` enum('No','Yes'),
  `requestedat` datetime,
  `is_sent` enum('No','Yes'),
  `refund_date` datetime,
  `is_refunded` enum('No','Yes'),
  `refund_amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `is_dispute` enum('No','Yes'),
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `token` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `createdat` datetime,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
