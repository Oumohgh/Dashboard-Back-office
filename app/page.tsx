'use client';

import { useEffect } from 'react';
import { useRouter } from 'next/navigation';

export default function Home() {
  const router = useRouter();

  useEffect(() => {
    // Redirect to the hotel moderation dashboard
    router.push('/dashboard');
  }, [router]);

  return null;
}
