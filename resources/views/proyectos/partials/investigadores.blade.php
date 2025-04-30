    @foreach ($investigadores as $index => $inv)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2 mb-3">
            <div class="card h-100">
                <div class="card-body p-3">
                    <h5 class="card-title text-primary">
                        <i class="fas fa-user mr-2"></i> Investigador {{ $index + 1 }}
                    </h5>
                    <p class="card-text text-muted mb-0">{{ $inv->nombre }}</p>
                </div>
            </div>
        </div>
    @endforeach
