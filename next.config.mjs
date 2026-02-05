/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  webpack: (config, { isServer }) => {
    // Allow serving static HTML files
    config.resolve.alias = {
      ...config.resolve.alias,
    };
    return config;
  },
  // Enable static file serving for public directory
  staticPageGenerationTimeout: 120,
};

export default nextConfig;
