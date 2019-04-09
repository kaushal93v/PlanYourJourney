cyc = read.csv('saftey index.csv')

head(cyc)
cyc[-1]
cyc.norm = scale(cyc[-1])
k.means.fit <- kmeans(cyc.norm, 3)
attributes(k.means.fit)
k.means.fit$centers
k.means.fit$cluster
k.means.fit$size

cyc['cluster'] <- k.means.fit$cluster

write.csv(cyc,file = 'suburb_clusters.csv',row.names = FALSE)
