import { readFileSync } from 'fs';
import path from 'path';
import { notFound } from 'next/navigation';

export default function CatchAllPage({ params }: { params: { slug: string[] } }) {
  try {
    // Build file path from slug
    let filePath = path.join(
      process.cwd(),
      'bootstrap-admin-template-free',
      ...(params.slug || [])
    );

    // If no slug or ends with /, serve index.html
    if (!params.slug || params.slug.length === 0) {
      filePath = path.join(process.cwd(), 'bootstrap-admin-template-free', 'index.html');
    } else if (!filePath.endsWith('.html')) {
      // Try adding .html extension
      const withHtml = filePath + '.html';
      try {
        readFileSync(withHtml, 'utf-8');
        filePath = withHtml;
      } catch {
        // If .html version doesn't exist, try as directory with index.html
        filePath = path.join(filePath, 'index.html');
      }
    }

    const htmlContent = readFileSync(filePath, 'utf-8');

    return (
      <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
    );
  } catch (error) {
    notFound();
  }
}
