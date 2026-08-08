<?php
require_once __DIR__ . '/../app/config/config.php';

try {
    \ = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    \->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    \ = "
    TRUNCATE TABLE \services\;

    INSERT INTO \services\ (\	itle\, \slug\, \description\, \eatures\, \enefits\, \methodology\, \deliverables\, \	echnologies\, \industries_served\, \icon\, \status\) VALUES
    (
        'Digital Transformation & Consulting', 
        'digital-transformation-consulting', 
        'Comprehensive strategic consulting to navigate digital disruption, streamline operations, and drive growth.', 
        'Process Automation Architecture\nCloud Migration Strategies\nDigital Maturity Assessments\nChange Management Protocols', 
        'Reduces operational costs by up to 40%\nAccelerates speed-to-market for new products\nEnhances customer experience and engagement\nFosters data-driven decision making', 
        'We employ a holistic approach starting with a thorough audit of your current systems. We then architect a bespoke digital roadmap, integrate modern agile workflows, and manage the transition process to ensure zero downtime and maximum adoption.', 
        'Digital Maturity Report\nCloud Architecture Blueprint\nTransformation Roadmap\nExecutive Training Materials', 
        'Cloud Computing, AI/ML, Microservices, IoT', 
        'Public Sector, Finance, Manufacturing', 
        'fa-laptop-code', 
        'published'
    ),
    (
        'Document, Records & Information Management', 
        'document-records-management', 
        'Secure, systematic control of the creation, receipt, maintenance, use and disposition of records.', 
        'Electronic Document Management Systems (EDMS)\nAutomated Archiving & Retention\nOptical Character Recognition (OCR)\nCompliance & Audit Trails', 
        'Eliminates physical storage overhead\nEnsures strict regulatory compliance\nDrastically reduces document retrieval times\nProtects against unauthorized access', 
        'Our strategy begins with physical document digitization utilizing high-speed OCR. We then deploy scalable EDMS frameworks with role-based access control, ensuring your data lifecycle is governed from creation to secure deletion.', 
        'Digitized Archival Database\nDeployed EDMS Framework\nCompliance & Access Control Policy\nEnd-User Software Manuals', 
        'SharePoint, Laserfiche, Custom EDMS, Azure', 
        'Government, Healthcare, Legal', 
        'fa-folder-open', 
        'published'
    ),
    (
        'Enterprise Software & Workflow Automation', 
        'enterprise-software-workflow', 
        'Custom software solutions designed to automate complex workflows and boost operational efficiency.', 
        'Bespoke ERP & CRM Development\nBusiness Process Automation (BPA)\nAPI Integration Services\nLegacy System Modernization', 
        'Eliminates repetitive manual tasks\nMinimizes human error in critical processes\nCentralizes disparate business operations\nScales infinitely with organizational growth', 
        'We leverage iterative agile development to build enterprise-grade software. By analyzing your unique bottlenecks, we deploy automated scripts, unified dashboards, and secure APIs that talk seamlessly to your existing infrastructure.', 
        'Custom Enterprise Application\nAPI Documentation\nWorkflow Automation Scripts\nContinuous Integration Pipeline', 
        'PHP/Laravel, Node.js, Python, PostgreSQL', 
        'Logistics, Retail, Enterprise Business', 
        'fa-network-wired', 
        'published'
    ),
    (
        'IT Infrastructure & Systems Integration', 
        'it-infrastructure-integration', 
        'Robust infrastructure architecture and seamless integration of complex enterprise IT systems.', 
        'Server & Data Center Deployment\nNetwork Architecture & Optimization\nHardware Procurement\nDisaster Recovery Solutions', 
        'Guarantees 99.99% system uptime\nOptimizes network bandwidth and latency\nFuture-proofs hardware investments\nEnsures business continuity during outages', 
        'Our engineers conduct rigorous load testing and infrastructure auditing before designing scalable network topologies. We procure top-tier hardware, configure secure VLANs, and establish robust disaster recovery protocols.', 
        'Network Topology Schematics\nHardware & Software Inventory\nDisaster Recovery Playbook\nPerformance Baseline Report', 
        'Cisco, VMware, AWS, Hyper-V', 
        'Telecommunications, Government, Corporate', 
        'fa-server', 
        'published'
    ),
    (
        'Cybersecurity & Data Protection', 
        'cybersecurity-data-protection', 
        'Advanced security measures to protect critical data, ensure compliance, and mitigate cyber threats.', 
        'Vulnerability Assessments & Penetration Testing\nZero Trust Architecture\nData Encryption & Endpoint Security\n24/7 Security Operations Center (SOC)', 
        'Prevents catastrophic data breaches\nSecures sensitive customer information\nMaintains strict NDPR/GDPR compliance\nMitigates financial and reputational risk', 
        'We adopt a proactive defense-in-depth methodology. Our ethical hackers expose vulnerabilities through simulated attacks, followed by the deployment of robust encryption, strict access policies, and continuous real-time network monitoring.', 
        'Comprehensive Audit Report\nEndpoint Security Suite\nIncident Response Plan\nCompliance Certification', 
        'Kali Linux, Splunk, Firewalls, AES-256', 
        'Banking, Government, Healthcare', 
        'fa-shield-alt', 
        'published'
    ),
    (
        'Data Analytics, AI & Business Intelligence', 
        'data-analytics-ai', 
        'Transform raw data into actionable insights leveraging cutting-edge Artificial Intelligence and analytics.', 
        'Predictive Analytics Modeling\nData Warehousing\nInteractive BI Dashboards\nMachine Learning Algorithms', 
        'Uncovers hidden market trends\nOptimizes resource allocation\nImproves accuracy of financial forecasting\nEnhances personalization in customer service', 
        'We consolidate structured and unstructured data streams into a secure warehouse. Using advanced statistical models and BI tools, we visualize complex data sets, allowing stakeholders to make informed decisions backed by AI-driven predictions.', 
        'Custom BI Dashboard\nData Warehouse Architecture\nPredictive Algorithm Source Code\nMonthly Insight Reports', 
        'Power BI, Tableau, Python, TensorFlow', 
        'Finance, E-commerce, Public Sector', 
        'fa-chart-pie', 
        'published'
    ),
    (
        'Financial & Public-Sector Technology Solutions', 
        'financial-public-sector', 
        'Specialized, compliant technology frameworks tailored for financial institutions and government entities.', 
        'Secure Payment Gateways\ne-Government Portals\nTax & Revenue Management Systems\nRegulatory Compliance Automation', 
        'Streamlines citizen service delivery\nEnsures transparent financial reporting\nReduces administrative bottlenecks\nEnhances secure revenue collection', 
        'Understanding the strict regulatory environment, we design systems with security and compliance at the core. We integrate multi-factor authentication, secure transaction ledgers, and intuitive citizen-facing interfaces for government programs.', 
        'e-Government Portal Framework\nRevenue Management Dashboard\nCompliance Audit Logs\nSecure Transaction APIs', 
        'FinTech APIs, Blockchain, Java, Oracle', 
        'Government Ministries, Banks, NGOs', 
        'fa-landmark', 
        'published'
    ),
    (
        'Training, Managed Services & Technical Support', 
        'training-managed-services', 
        'Expert technical support, managed IT services, and comprehensive corporate training programs.', 
        '24/7 Helpdesk Support\nCorporate IT Skill Acquisition\nOutsourced Managed IT\nSystem Upgrades & Maintenance', 
        'Eliminates the need for an in-house IT team\nEmpowers staff with modern tech skills\nResolves technical issues instantly\nEnsures systems are always up-to-date', 
        'We provide end-to-end technical stewardship. Our certified trainers conduct immersive workshops to upskill your workforce, while our dedicated support team monitors your IT assets around the clock, managing updates and troubleshooting instantly.', 
        'Technical Support SLA\nEmployee Training Manuals\nMonthly Maintenance Reports\nHelpdesk Portal Access', 
        'ServiceNow, Zendesk, Microsoft 365, Active Directory', 
        'Corporate Enterprise, Startups, Education', 
        'fa-headset', 
        'published'
    );
    ";

    \->exec(\);
    echo "SUCCESS: The live database has been updated with the complete rich data for the unique services! You can safely delete this file now.";
    
} catch (PDOException \) {
    echo "ERROR: " . \->getMessage();
}
?>
