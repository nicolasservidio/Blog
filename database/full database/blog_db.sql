-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 07:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) DEFAULT '#007bff',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Technology', 'technology', 'Posts about technology and programming', '#007bff', 'active', '2025-10-18 21:21:36', '2025-10-18 21:21:36'),
(2, 'Lifestyle', 'lifestyle', 'Posts about lifestyle and personal experiences', '#28a745', 'active', '2025-10-18 21:21:36', '2025-10-18 21:21:36'),
(3, 'Travel', 'travel', 'Posts about travel and adventures', '#ffc107', 'active', '2025-10-18 21:21:36', '2025-10-18 21:21:36'),
(4, 'Food', 'food', 'Posts about food and recipes', '#dc3545', 'active', '2025-10-18 21:21:36', '2025-10-18 21:21:36'),
(5, 'Health', 'health', 'Posts about health and wellness', '#6f42c1', 'active', '2025-10-18 21:21:36', '2025-10-18 21:21:36'),
(6, 'Science', 'science', 'The Science category explores the latest discoveries, breakthroughs, and innovations across all fields of scientific inquiry - from astronomy and biology to artificial intelligence and quantum computing. It provides accessible, evidence-based insights into how science shapes our world, drives technological progress, and helps solve global challenges.', '#eb7100', 'active', '2025-10-20 17:16:46', '2025-10-20 17:17:58'),
(7, 'Stoicism', 'stoicism', 'Stoicism is a practical philosophy for living well by focusing on virtue, resilience, and accepting what you cannot control. It teaches that peace comes from mastering your judgments and responses, not from changing external events', '#b54ede', 'active', '2025-10-20 17:21:44', '2025-10-20 17:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL COMMENT 'Options: ''draft'', ''published'', ''archived''',
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `status`, `author_id`, `category_id`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'The Future of Artificial Intelligence: How AI Is reshaping Every Industry in 2025', 'ai-future-reshaping-industries-2025', '**Artificial intelligence** is rapidly evolving, reshaping industries and daily life. In 2025, AI has become multimodal, understanding and integrating text, images, audio, and video to deliver richer, more personalized experiences - from AI assistants in cars to creative tools in advertising.\r\n\r\n**AI agents** are now central to enterprise workflows, automating complex tasks and connecting data across systems. Platforms like Google Agentspace enable secure, scalable deployment, helping organizations like Banco BV and Deloitte boost productivity and uncover hidden insights.\r\n\r\nThe focus has shifted from experimentation to optimization. Companies are refining AI stacks for better performance, cost-efficiency, and ROI, using advanced infrastructure to speed up processing and reduce expenses.\r\n\r\nAI is also breaking down silos, democratizing access across departments and empowering non-technical users to innovate. Meanwhile, breakthroughs in AI research - like MIT’s FlowER for chemical reaction prediction and Delphi-2M for long-term disease forecasting—are unlocking new possibilities in science and healthcare.\r\n\r\nAs AI becomes more capable, responsible development remains critical to address bias, security, and ethical concerns - ensuring the technology benefits _everyone_.', 'Artificial intelligence is no longer just a futuristic concept - it\'s actively transforming industries, from healthcare to transportation. In 2025, we\'re seeing AI agents capable of performing real cognitive work, such as writing and debugging complex code, while advancements in robotics hint at machines that can navigate homes and assist the elderly. Large language models (LLMs) like ChatGPT have moved beyond simple text generation, now engaging in conversational interactions with increasing context awareness. However, challenges remain, including vulnerabilities to prompt injection attacks and persistent linguistic biases that favor certain dialects over others. As AI infrastructure scales rapidly, the focus is shifting toward building safer, more equitable systems that benefit all of humanity.', 'https://techvidvan.com/tutorials/wp-content/uploads/2020/04/future-of-AI.jpg', 'published', 13, 1, 'AI in 2025: How Artificial Intelligence Is Transforming the World', 'Discover how artificial intelligence is transforming industries in 2025: from healthcare to automation. Explore the latest AI trends, breakthroughs, and real-world applications shaping the future', '2025-10-20 12:48:21', '2025-10-20 15:33:52'),
(2, 'How LLMs Are Transforming Business Intelligence and Data Analytics', 'llms-business-intelligence-data-analytics', '## How LLMs Are Transforming Business Intelligence and Data Analytics\r\n\r\nLarge Language Models (LLMs) are revolutionizing how businesses analyze data and make decisions. By bridging the gap between complex data systems and human language, LLMs are **democratizing access to insights**, enabling non-technical users to explore data through natural language queries.\r\n\r\n### Natural Language Querying\r\nInstead of writing SQL or navigating dashboards, employees can now ask questions like *“Show sales trends in Europe last quarter”* and get instant answers. Tools like **Tableau’s Ask Data** and **Power BI’s AI features** use LLMs to translate these queries into database commands, making analytics accessible across departments.\r\n\r\n### Unlocking Unstructured Data\r\nAround **80% of enterprise data is unstructured**—emails, reviews, social media, and support tickets. LLMs analyze this data at scale, extracting sentiment, trends, and hidden patterns. For example:\r\n- **Amazon** uses LLMs to personalize shopping experiences and improve demand forecasting.\r\n- **Moody’s** automates financial analysis by processing news and credit reports.\r\n- **Johnson & Johnson** accelerates drug discovery by predicting chemical reactions.\r\n\r\n### Automated Insights and Reporting\r\nLLMs generate **real-time summaries, visualizations, and reports**. Platforms like **Wordsmith** create plain-language reports from sales or operational data, while **DataRobot** combines LLMs with predictive models to deliver actionable forecasts—reducing manual analysis time.\r\n\r\n### Challenges and Considerations\r\nDespite their power, LLMs pose challenges:\r\n- **Bias**: Models may reflect biases in training data.\r\n- **Privacy**: Handling sensitive data requires strict compliance.\r\n- **Cost**: Cloud-based LLM services can be expensive at scale.\r\n\r\n### The Future of BI\r\nGartner predicts that by 2025, **over 50% of business queries** will be made via natural language or voice. As LLMs integrate deeper into BI tools, they will not only answer questions but **anticipate needs**, recommend actions, and drive smarter, faster decisions.\r\n\r\nLLMs are no longer a novelty—they’re becoming the **central nervous system of modern business intelligence**.', 'Large Language Models (LLMs) are revolutionizing business intelligence by enabling natural language queries, automating insights from unstructured data, and democratizing access to analytics. By simply asking questions in plain English, non-technical users can retrieve complex data insights, while AI-powered analysis uncovers trends in customer feedback, reports, and real-time business data—transforming how organizations make decisions.', 'https://www.datocms-assets.com/16499/1711928342-future-trends-in-ai-business-intelligence.png?auto=format&dpr=0.8&w=1005', 'draft', 13, 1, 'LLMs in Business Intelligence: Transforming Data Analytics', 'Discover how Large Language Models (LLMs) are revolutionizing data analytics and business intelligence—enabling natural language queries, automating insights, and unlocking value from unstructured data in 2025', '2025-10-20 16:25:32', '2025-10-20 16:25:32'),
(3, 'fdfdfhhh', 'ree', 'fdfh', 'fdf', 'https://techvidvan.com/tutorials/wp-content/uploads/2020/04/future-of-AI.jpg', 'archived', 13, 2, 'fdfh', 'fdf', '2025-10-20 16:36:15', '2025-10-20 16:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `bio`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@blog.com', '$2y$10$ZtfQ8C/AD7WrCKYq7pQNiOEv.CKAMpx6DZRqKu9bmCd1VSRPXLXA2', 'admin', NULL, NULL, 'active', '2025-10-18 21:20:55', '2025-10-20 11:34:48'),
(2, 'Nicolás', 'nicolas@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-19 11:14:01', '2025-10-20 11:35:42'),
(3, 'Juan', 'juan@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-19 11:19:34', '2025-10-20 11:36:25'),
(4, 'Pedro', 'pedro@email.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 09:40:59', '2025-10-20 11:36:27'),
(5, 'Maria', 'maria@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 09:43:20', '2025-10-20 11:36:30'),
(6, 'Rosario', 'rosario@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:00:38', '2025-10-20 11:36:33'),
(7, 'Christian', 'christian@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:02:07', '2025-10-20 11:36:36'),
(8, 'Fred', 'fred@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:04:18', '2025-10-20 11:36:39'),
(9, 'Veru', 'veru@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:14:52', '2025-10-20 11:36:42'),
(10, 'Augusto', 'augusto@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:21:11', '2025-10-20 11:36:45'),
(11, 'Hector', 'hector@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:23:14', '2025-10-20 11:36:48'),
(12, 'Emily', 'emily@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:26:45', '2025-10-20 11:36:50'),
(13, 'Rosa', 'rosa@blog.com', '$2y$10$F9RB5IY7zUloPkawol93ouM9Oe6/f5AbXJbTh3vy7KPY5jn6bvgly', 'user', NULL, NULL, 'active', '2025-10-20 10:53:23', '2025-10-20 11:36:53'),
(14, 'Pablo', 'pablo@blog.com', '$2y$10$8VdYlp53/FtA3bAtOP7NoOfI3lGOvYyLb41iQLpsYckpCOfqtdukC', 'user', NULL, NULL, 'active', '2025-10-20 11:43:24', '2025-10-20 11:44:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_author` (`author_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
