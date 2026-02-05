import { readFileSync } from 'fs';
import path from 'path';
import { NextRequest, NextResponse } from 'next/server';

export async function GET(
  request: NextRequest,
  { params }: { params: { path: string[] } }
) {
  const filePath = path.join(
    process.cwd(),
    'bootstrap-admin-template-free',
    ...params.path
  );

  try {
    const fileContent = readFileSync(filePath, 'utf-8');
    
    // Determine content type based on file extension
    const ext = path.extname(filePath).toLowerCase();
    const contentTypeMap: { [key: string]: string } = {
      '.html': 'text/html',
      '.css': 'text/css',
      '.js': 'application/javascript',
      '.json': 'application/json',
      '.jpg': 'image/jpeg',
      '.jpeg': 'image/jpeg',
      '.png': 'image/png',
      '.gif': 'image/gif',
      '.svg': 'image/svg+xml',
    };

    const contentType = contentTypeMap[ext] || 'text/plain';

    return new NextResponse(fileContent, {
      headers: { 'Content-Type': contentType },
    });
  } catch (error) {
    return new NextResponse('File not found', { status: 404 });
  }
}
