
--
-- Table structure for table `m_tabungan`
--

CREATE TABLE `m_tabungan` (
  `kd` varchar(50) NOT NULL,
  `min_debet` varchar(10) DEFAULT NULL,
  `max_kredit` varchar(10) DEFAULT NULL,
  `min_saldo` varchar(10) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `m_tabungan`
--

INSERT INTO `m_tabungan` (`kd`, `min_debet`, `max_kredit`, `min_saldo`, `postdate`) VALUES
('5a1a57314ce9fc84ad4581a7b3d8181b', '10000', '500000', '1000', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_tabungan`
--
ALTER TABLE `m_tabungan`
  ADD PRIMARY KEY (`kd`);
COMMIT;








