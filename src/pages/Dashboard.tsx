import React from 'react';
import {
  Grid,
  Paper,
  Typography,
  Box,
} from '@mui/material';
import { useQuery } from '@tanstack/react-query';
import { eventService } from '../services/events';
import { venueService } from '../services/venues';
import { specialService } from '../services/specials';
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from 'recharts';
import { Event } from '../types/event';
import { Special } from '../types/special';

interface StatCard {
  title: string;
  value: number;
  color: string;
}

export const Dashboard: React.FC = () => {
  const { data: events = [] } = useQuery<Event[]>({
    queryKey: ['events'],
    queryFn: eventService.getAll,
  });

  const { data: venues = [] } = useQuery({
    queryKey: ['venues'],
    queryFn: venueService.getAll,
  });

  const { data: specials = [] } = useQuery<Special[]>({
    queryKey: ['specials'],
    queryFn: specialService.getAll,
  });

  const stats: StatCard[] = [
    {
      title: 'Total Events',
      value: events.length,
      color: '#1976d2',
    },
    {
      title: 'Total Venues',
      value: venues.length,
      color: '#2e7d32',
    },
    {
      title: 'Active Specials',
      value: specials.filter((s: Special) => s.status === 'active').length,
      color: '#ed6c02',
    },
  ];

  const eventTypeData = events.reduce((acc: { type: string; count: number }[], event) => {
    const existing = acc.find(item => item.type === event.type);
    if (existing) {
      existing.count++;
    } else {
      acc.push({ type: event.type, count: 1 });
    }
    return acc;
  }, []);

  return (
    <Box sx={{ flexGrow: 1, p: 3 }}>
      <Typography variant="h4" gutterBottom>
        Dashboard
      </Typography>
      
      <Grid container spacing={3}>
        {stats.map((stat) => (
          <Grid 
            key={stat.title} 
            component="div"
            item
            xs={12} 
            sm={4}
          >
            <Paper
              sx={{
                p: 2,
                display: 'flex',
                flexDirection: 'column',
                height: 140,
                bgcolor: stat.color,
                color: 'white',
              }}
            >
              <Typography component="h2" variant="h6" gutterBottom>
                {stat.title}
              </Typography>
              <Typography component="p" variant="h4">
                {stat.value}
              </Typography>
            </Paper>
          </Grid>
        ))}

        <Grid 
          component="div"
          item
          xs={12}
        >
          <Paper sx={{ p: 2, height: 400 }}>
            <Typography variant="h6" gutterBottom>
              Events by Type
            </Typography>
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={eventTypeData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="type" />
                <YAxis />
                <Tooltip />
                <Bar dataKey="count" fill="#1976d2" />
              </BarChart>
            </ResponsiveContainer>
          </Paper>
        </Grid>
      </Grid>
    </Box>
  );
};

export default Dashboard; 