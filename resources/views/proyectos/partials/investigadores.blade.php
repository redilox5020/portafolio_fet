    @foreach ($investigadores as $index => $inv)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="fas fa-user mr-2"></i> Investigador {{ $index + 1 }}
                    </h5>
                    <p class="card-text text-muted mb-0">{{ $inv->nombre }}</p>
                </div>
            </div>
        </div>
    @endforeach
