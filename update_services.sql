INSERT INTO `services` (`title`, `slug`, `description`, `icon`, `status`) VALUES
('Digital Transformation & Consulting', 'digital-transformation-consulting', 'Comprehensive strategic consulting to navigate digital disruption, streamline operations, and drive growth.', 'fa-laptop-code', 'published'),
('Document, Records & Information Management', 'document-records-management', 'Secure, systematic control of the creation, receipt, maintenance, use and disposition of records.', 'fa-folder-open', 'published'),
('Enterprise Software & Workflow Automation', 'enterprise-software-workflow', 'Custom software solutions designed to automate complex workflows and boost operational efficiency.', 'fa-network-wired', 'published'),
('IT Infrastructure & Systems Integration', 'it-infrastructure-integration', 'Robust infrastructure architecture and seamless integration of complex enterprise IT systems.', 'fa-server', 'published'),
('Cybersecurity & Data Protection', 'cybersecurity-data-protection', 'Advanced security measures to protect critical data, ensure compliance, and mitigate cyber threats.', 'fa-shield-alt', 'published'),
('Data Analytics, AI & Business Intelligence', 'data-analytics-ai', 'Transform raw data into actionable insights leveraging cutting-edge Artificial Intelligence and analytics.', 'fa-chart-pie', 'published'),
('Financial & Public-Sector Technology Solutions', 'financial-public-sector', 'Specialized, compliant technology frameworks tailored for financial institutions and government entities.', 'fa-landmark', 'published'),
('Training, Managed Services & Technical Support', 'training-managed-services', 'Expert technical support, managed IT services, and comprehensive corporate training programs.', 'fa-headset', 'published')
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`), `status` = VALUES(`status`);
