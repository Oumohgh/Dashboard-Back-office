import { readFileSync } from 'fs';
import path from 'path';

export default function Dashboard() {
  const filePath = path.join(process.cwd(), 'bootstrap-admin-template-free', 'index.html');
  const htmlContent = readFileSync(filePath, 'utf-8');

  return (
    <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
  );
}
